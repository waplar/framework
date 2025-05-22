<?php

namespace Illustrator\Waiter;

use Closure;
use Illuminate\Support\Fluent;
use Illustrator\Support\Facades\Poet;
use Illustrator\Waiter\Blueprint\Column;
use Illustrator\Waiter\Blueprint\Command;
use Illustrator\Waiter\Schema\ColumnDefinition;
use ReflectionException;
use ReflectionMethod;

class Blueprint
{

    use Column, Command;

    /**
     * The columns that should be added to the table.
     *
     * @var Schema\ColumnDefinition[]
     */
    protected array $columns = [];

    /**
     * The commands that should be run for the table.
     *
     * @var Fluent[]
     */
    protected array $commands = [];

    /**
     * Construct a Blueprint instance
     *
     * @param string $table
     * @param string $prefix
     */
    public function __construct(
        protected string $table,
        protected string $prefix
    ) {
        // ...
    }

    /**
     * 批量设置列定义
     * Column definition as a group
     *
     * @param array[]                                                     $columns
     * @param Closure(Schema\ColumnDefinition): (Schema\ColumnDefinition) $callback
     *
     * @return array
     */
    public function group(array $columns, Closure $callback): array
    {
        return collect($columns)->map(function (Schema\ColumnDefinition $column) use ($callback) {
            $definition = $callback($column);

            if (!($definition instanceof ColumnDefinition)) {
                return $column;
            }

            // 合并公共部分
            // Merge common parts
            collect($definition->all())->map(function ($value, $key) use ($column) {
                $column->set($key, $value);
            });

            $this->columns[$column['name']]['definition'] = $column;

            return $column;
        })->toArray();
    }

    /**
     * Stay in line with laravel
     *
     * @param string $type
     * @param string $name
     * @param array  $parameters
     *
     * @return Schema\ColumnDefinition
     */
    public function addColumn(string $type, string $name, array $parameters = []): Schema\ColumnDefinition
    {
        $this->columns[$name] = [
            'attributes' => array_merge(compact('type'), $parameters),
            'definition' => $column = new Schema\ColumnDefinition(compact('name')),
        ];

        return $column;
    }

    /**
     * Stay in line with laravel
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Stay in line with laravel
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * Stay in line with laravel
     *
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Stay in line with laravel
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Stay in line with laravel
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return Fluent
     */
    protected function addCommand(string $name, array $parameters = []): Fluent
    {
        $this->commands[] = $command = $this->createCommand($name, $parameters);

        return $command;
    }

    /**
     * Stay in line with laravel
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return Fluent
     */
    protected function createCommand(string $name, array $parameters = []): Fluent
    {
        return new Fluent(array_merge(compact('name'), $parameters));
    }

    /**
     * 过滤来自调用者的默认值
     * Filtering default values from the caller
     *
     * @param array $args
     *
     * @return array
     */
    protected function filterDefaultsFromCaller(array $args): array
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
        try {
            $method = new ReflectionMethod($trace['class'], $trace['function']);
        } catch (ReflectionException $e) {
            Poet::fail($e->getMessage());

            return [];
        }

        $params = $method->getParameters();

        $filtered = [];

        foreach ($params as $index => $param) {
            // 跳过第一个参数（比如 $column）
            if (!array_key_exists($index, $args)) {
                continue;
            }

            $name = $param->getName();

            if (
                !$param->isDefaultValueAvailable() ||
                $param->getDefaultValue() !== $args[$index]
            ) {
                $filtered[$name] = $args[$index];
            }
        }

        return $filtered;
    }

}
