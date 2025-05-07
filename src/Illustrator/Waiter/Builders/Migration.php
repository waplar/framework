<?php

namespace Illustrator\Waiter\Builders;

use Closure;
use Illustrator\Waiter\Manager;
use Illuminate\Pipeline\Pipeline;
use Illustrator\Waiter\Builders\Migration\UpCreate;
use Illustrator\Waiter\Constants\Waiter as WaiterConstants;

class Migration extends Builder
{

    /**
     * Handle
     *
     * @param  array    $params
     * @param  Closure  $next
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
                'hook' => $fluent[$current]['hook'],
                'summary' => $fluent[WaiterConstants::SUMMARY]['package'],
                'comment' => $fluent[$current]['comment'],
            ], $this->stubDisk()->get('migration.stub'));

            return $next($stub);
        };

        $pipes[] = function (string $stub, Closure $next) use ($fluent, $current) {
            $stub = $this->params([
                'upSchema' => $this->upSchema(
                    $fluent[WaiterConstants::BLUEPRINT]
                ),
                'downSchema' => $this->downSchema(),
            ], $stub);

            return $next($stub);
        };

        // 格式化代码并将参数记录到管理类
        // Format the code and log the parameters to the management class
        $pipes[] = function (string $stub, Closure $next) use ($fluent, $current) {
            $stub = $this->format($stub);
            $uuid = $fluent[WaiterConstants::TABLE]['name'];

            app(Manager::class)->appendStub("$current.$uuid", [
                'filepath' => $fluent[$current]['filepath'],
                'content' => $stub,
            ]);

            return $next($stub);
        };

        app(
            Pipeline::class
        )->send('')->through($pipes)->then(function ($stub) {
            return $stub;
        });

        return $next($params);
    }

    private function upSchema(array $params): string
    {
        return (new UpCreate($params, '$this->summary::TABLE'))->getStub();
    }

    private function downSchema(): string
    {
        return 'Schema::dropIfExists($this->summary::TABLE);';
    }

}