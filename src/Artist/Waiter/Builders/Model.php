<?php

namespace Artist\Waiter\Builders;

use Artist\Waiter\Constants\Waiter as WaiterConstants;
use Artist\Waiter\Manager;
use Artist\Waiter\Schema\ColumnDefinition;
use Closure;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;

class Model extends Builder
{

    /**
     * Handle
     *
     * @param array   $params
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(array $params, Closure $next): mixed
    {
        [$fluent, $builders] = $params;

        $pipes = [];
        $current = $builders[__CLASS__];

        // 设置基础的参数
        // Set basic parameters
        $pipes[] = function (string $stub, Closure $next) use ($fluent, $current) {
            $stub = $this->params([
                'namespace' => $fluent[$current]['namespace'],
                'classname' => $fluent[$current]['classname'],
                'comment' => $fluent[$current]['comment'],
                'extends' => $fluent[$current]['extends'] ?? \Artist\Foundation\Database\Eloquent\Model::class,
                'summary' => $fluent[WaiterConstants::SUMMARY]['package'],
            ], $this->stubDisk()->get('model.stub'));

            return $next($stub);
        };

        // 设置额外的定义信息
        // Set additional definition information
        $pipes[] = function (string $stub, Closure $next) use ($fluent, $current) {
            $stub = $this->params([
                'timestamps' => $fluent[$current]['definition']['timestamps'] ?? true,
                'incrementing' => $fluent[$current]['definition']['incrementing'] ?? true,
            ], $stub);

            return $next($stub);
        };

        $pipes[] = function (string $stub, Closure $next) use ($fluent, $current) {
            $casts = $usePackages = [];

            collect(
                $fluent[WaiterConstants::SCHEMA]['up']['create']['columns'] ?? []
            )->each(function (ColumnDefinition $value) use (&$casts, &$usePackages) {
                $cast = $value->get('cast');

                if ($value->has('cast')) {
                    // 检查是否需要引入其他类
                    // Check whether additional classes need to be introduced
                    if (class_exists($cast)) {
                        $packageAlias = Str::of($cast)->explode("\\");
                        $packageAlias = $packageAlias
                            ->only(1, $packageAlias->count() - 1, $packageAlias->count())
                            ->implode('');

                        $usePackages[$cast] = "use $cast as $packageAlias;";
                        $casts[$value->get('name')] = "$packageAlias::class";
                    }
                    // 默认情况下直接赋值
                    // Direct assignment by default
                    else {
                        $casts[$value->get('name')] = $cast;
                    }
                }
            })->toArray();

            $stub = $this->params([
                'casts' => $this->arrayConvertedToCode($casts),
                'usePackages' => collect($usePackages)->implode("\n"),
            ], $stub);

            return $next($stub);
        };

        // 格式化代码并将参数记录到管理类
        // Format the code and log the parameters to the management class
        $pipes[] = function (string $stub, Closure $next) use ($fluent, $current) {
            $stub = $this->format($stub);
            $uuid = $fluent[WaiterConstants::TABLE]['name'];

            app(Manager::class)
                ->appendModel($uuid, $fluent[$current]['package'])
                ->appendStub("$current.$uuid", [
                    'filepath' => $fluent[$current]['filepath'],
                    'content' => $stub,
                ]);

            return $next($stub);
        };

        app(Pipeline::class)
            ->send('')
            ->through($pipes)
            ->then(function ($stub) {
                return $stub;
            });

        return $next($params);
    }

}
