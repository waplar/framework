<?php

namespace Artist\Waiter;

use Artist\Waiter\Schema\ColumnDefinition;
use Closure;
use Illuminate\Support\Fluent;

class Blueprint
{

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
     * Column definition as a group
     *
     * @param ColumnDefinition[]                                          $columns
     * @param Closure(Schema\ColumnDefinition): (Schema\ColumnDefinition) $callback
     *
     * @return void
     */
    public function group(array $columns, Closure $callback): void
    {
        $definition = $callback(new ColumnDefinition());

        if (!($definition instanceof ColumnDefinition)) {
            return;
        }

        $columns = collect(
            $columns
        )->mapWithKeys(function (Schema\ColumnDefinition $column) use ($definition) {
            // Merge and return the common parts
            collect($definition->all())->map(function ($value, $key) use ($column) {
                $column->set($key, $value);
            });

            return [$column['name'] => $column];
        })->all();

        $this->columns = array_merge($this->columns, $columns);
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     * @param bool   $autoIncrement
     * @param bool   $unsigned
     *
     * @return Schema\ColumnDefinition
     */
    public function integer(
        string $column,
        bool $autoIncrement = false,
        bool $unsigned = false
    ): Schema\ColumnDefinition {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            compact('autoIncrement', 'unsigned')
        );
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
        $this->columns[$name] = $column = new Schema\ColumnDefinition(
            array_merge(compact('type', 'name'), $parameters)
        );

        return $column;
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     * @param bool   $autoIncrement
     * @param bool   $unsigned
     *
     * @return Schema\ColumnDefinition
     */
    public function bigInteger(
        string $column,
        bool $autoIncrement = false,
        bool $unsigned = false
    ): Schema\ColumnDefinition {
        return $this->addColumn(__FUNCTION__, $column, compact('autoIncrement', 'unsigned'));
    }

    /**
     * Create a new tiny text column on the table.
     *
     * @param string $column
     *
     * @return Schema\ColumnDefinition
     */
    public function tinyText(string $column): Schema\ColumnDefinition
    {
        return $this->addColumn(__FUNCTION__, $column);
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     *
     * @return Schema\ColumnDefinition
     */
    public function text(string $column): Schema\ColumnDefinition
    {
        return $this->addColumn(__FUNCTION__, $column);
    }

    /**
     * Stay in line with laravel
     *
     * @param string   $column
     * @param int|null $length
     *
     * @return Schema\ColumnDefinition
     */
    public function string(string $column, int $length = null): Schema\ColumnDefinition
    {
        return $this->addColumn(__FUNCTION__, $column, compact('length'));
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
     * @param string $value
     *
     * @return Fluent
     */
    public function comment(string $value): Fluent
    {
        return $this->addCommand(__FUNCTION__, compact('value'));
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

}
