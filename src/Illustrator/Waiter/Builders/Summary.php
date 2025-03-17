<?php

namespace Illustrator\Waiter\Builders;

use Closure;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;
use Illustrator\Waiter\Constants\Waiter as WaiterConstants;
use Illustrator\Waiter\Manager;
use Illustrator\Waiter\Schema\ColumnDefinition;

class Summary extends Builder
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
                'table' => $fluent[WaiterConstants::TABLE]['name'],
                'summaryPackage' => \Illustrator\Waiter\Abstracts\Summary::class,
            ], $this->stubDisk()->get('summary.stub'));

            return $next($stub);
        };

        // 提取参数，为下一步构建做准备
        // Extract parameters to prepare for the next build
        $pipes[] = function (string $stub, Closure $next) use ($fluent, $current) {
            $primaryKey = "'id'";
            $hidden = $fillable = $guarded = [];

            $columns = collect(
                $fluent[WaiterConstants::SCHEMA]['up']['create']['columns']
            )->filter(function (ColumnDefinition $value) {
                return $value->has('summary');
            })->each(function (ColumnDefinition $value) use (&$hidden, &$fillable, &$guarded, &$primaryKey) {
                $upperName = Str::upper($value->get('name'));

                if ($value->has('hidden')) {
                    $hidden[] = "self::$upperName";
                }

                if ($value->has('fillable')) {
                    $fillable[] = "self::$upperName";
                }

                if ($value->has('guarded')) {
                    $guarded[] = "self::$upperName";
                }

                if ($value->has('primary')) {
                    $primaryKey = "self::$upperName";
                }
            })->toArray();

            $stub = $this->params([
                'hidden' => collect($hidden)->implode(", "),
                'fillable' => collect($fillable)->implode(", "),
                'guarded' => collect($guarded)->implode(", "),
                'primaryKey' => $primaryKey,
            ], $stub);

            return $next([$stub, $columns]);
        };

        // 构建参数代码
        // Build parameter code
        $pipes[] = function (array $params, Closure $next) use ($fluent, $current) {
            [$stub, $columns] = $params;

            // 过滤不需要的字段信息
            // Filter out unnecessary fields
            $columns = collect($columns)->map(function (array $value) {
                return collect($value)->filter(function (mixed $value, string $key) {
                    return $key !== 'summary';
                });
            })->toArray();

            $constantsStub = $this->stubDisk()->get('const.stub');

            // 填充参数到存根
            // Fill parameters into the stub
            $stub = $this->params([
                'metaColumns' => $this->arrayConvertedToCode($columns),
                'columnConstants' => collect(
                    array_keys($columns)
                )->filter(function (string $value) {
                    // 过滤被保留命名的常量
                    // Filters are reserved for named constants
                    return !in_array(Str::upper($value), [
                        'TABLE',
                        'PRIMARY_KEY',
                        'HIDDEN',
                        'FILLABLE',
                        'GUARDED',
                    ]);
                })->map(function (string $value) use ($columns, $constantsStub) {
                    return $this->params([
                        'comment' => $columns[$value]['comment'] ?? '',
                        'name' => Str::upper($value),
                        'value' => "'$value'",
                        '@var' => 'string',
                    ], $constantsStub);
                })->implode("\n"),
            ], $stub);

            return $next($stub);
        };

        // 格式化代码并将参数记录到管理类
        // Format the code and log the parameters to the management class
        $pipes[] = function (string $stub, Closure $next) use ($fluent, $current) {
            $stub = $this->format($stub);
            $uuid = $fluent[WaiterConstants::TABLE]['name'];

            app(Manager::class)
                ->appendSummary($uuid, $fluent[$current]['package'])
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
