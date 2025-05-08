<?php

namespace Illustrator\Waiter\Builders\Migration;

use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Illustrator\Waiter\Builders\Builder;
use Nette\PhpGenerator\Literal;

/**
 * @todo 需要完善默认参数过滤，补齐注释
 */
class UpCreate extends Builder
{

    /**
     * 列参数信息
     *
     * @var Collection
     */
    private Collection $params;

    /**
     * 表名称
     *
     * @var string
     */
    private string $table;

    /**
     * 存根信息
     *
     * @var string
     */
    private string $stub;

    /**
     * Schema::create 生成器实例
     * Schema::create generator instance
     *
     * @param  array   $params
     * @param  string  $table
     */
    public function __construct(array $params, string $table)
    {
        $this->params = collect($params);
        $this->table = $table;
        $this->stub = $this->stubDisk('migration')->get('up.create.stub');

        $this->stub = $this->param('table', $this->table, $this->stub);

        $this->columns();
        $this->commands();
    }

    /**
     * 获取存根信息
     *
     * @return string
     */
    public function getStub(): string
    {
        return $this->stub;
    }

    private function commands(): void
    {
        $commands = collect(
            $this->params->get('commands')
        )->map(function (Fluent $params) {
            $attributes = collect($params)->map(function (
                mixed $value,
                string $key
            ) use ($params) {
                if ($key === 'columns' && $params['name'] === 'unique') {
                    return collect($value)->map(function (string $column) {
                        return new Literal($this->constantReference($column));
                    })->toArray();
                }

                return $value;
            })->except(['name'])->map(function (
                mixed $value,
                string $key
            ) {
                return $this->namedMethodParameter($key, $value);
            })->implode(', ');

            $str = implode('->', [
                '$table',
                $params['name'] . "($attributes)",
            ]);

            return "$str;";
        })->implode('');

        $this->stub = $this->param('commands', $commands, $this->stub);
    }

    private function columns(): void
    {
        $columns = collect(
            $this->params->get('columns')
        )->map(function (array $params) {
            // 处理列参数定义
            // Processing column parameter definition
            $definition = collect(
                $params['definition']
            )->except(['name', 'summary', 'fillable', 'cast'])->map(function (
                mixed $value,
                string $key
            ) {
                if (in_array($key, [
                    'autoIncrement',
                    'change',
                    'first',
                    'invisible',
                    'persisted',
                    'unsigned',
                    'useCurrent',
                    'useCurrentOnUpdate',
                    'nullable',
                ])) {
                    return "$key()";
                }

                $methodParameters = $this->methodParameter($value);

                return $key . '(' . $methodParameters . ')';
            });

            unset($params['attributes']['column']);

            // 处理列属性定义
            // Processing column attribute definitions
            $columnAttributes = collect([
                'column' => $this->constantReference($params['definition']['name']),
                ...$params['attributes'],
            ])->except(['type'])->map(function (mixed $value, string $key) {
                return $this->namedMethodParameter($key, $value);
            })->implode(', ');

            // 合成链式调用
            // Synthetic Chain Calls
            $str = implode('->', array_merge([
                '$table',
                $params['attributes']['type'] . "($columnAttributes)",
            ], $definition->toArray()));

            return "$str;";
        })->implode('');

        $this->stub = $this->param('columns', $columns, $this->stub);
    }

    /**
     * 方法参数生成 (命名参数)
     * Method parameter generation (named parameters)
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return string
     */
    private function namedMethodParameter(string $key, mixed $value): string
    {
        return implode(': ', [
            $key,
            $this->methodParameter($value),
        ]);
    }

    /**
     * 方法参数生成
     * Method parameter generation
     *
     * @param  mixed  $value
     *
     * @return string
     */
    private function methodParameter(mixed $value): string
    {
        if (gettype($value) === 'string' && Str::of($value)->startsWith('$this->')) {
            return $value;
        }

        return match (gettype($value)) {
            'string' => "'$value'",
            'boolean' => $value ? 'true' : 'false',
            'integer' => $value,
            'array' => $this->arrayToCode($value),
            default => gettype($value),
        };
    }

    /**
     * 列常量引用
     * Column constant reference
     *
     * @param  string  $column
     *
     * @return string
     */
    private function constantReference(string $column): string
    {
        $column = Str::of($column)->upper();

        return implode('::', [
            '$this->summary',
            $column,
        ]);
    }

}
