<?php

namespace Illustrator\Blueprint;

use Illustrator\Waiter\Schema\ColumnDefinition;

trait Column
{

    /**
     * Stay in line with laravel
     *
     * @param string $column
     * @param bool   $autoIncrement
     * @param bool   $unsigned
     *
     * @return ColumnDefinition
     */
    public function integer(string $column, bool $autoIncrement = false, bool $unsigned = false): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     * @param bool   $autoIncrement
     * @param bool   $unsigned
     *
     * @return ColumnDefinition
     */
    public function bigInteger(string $column, bool $autoIncrement = false, bool $unsigned = false): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new tiny text column on the table.
     *
     * @param string $column
     *
     * @return ColumnDefinition
     */
    public function tinyText(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     *
     * @return ColumnDefinition
     */
    public function text(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string   $column
     * @param int|null $length
     *
     * @return ColumnDefinition
     */
    public function string(string $column, int $length = null): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     * @param bool   $autoIncrement
     *
     * @return ColumnDefinition
     */
    public function unsignedBigInteger(string $column, bool $autoIncrement = false): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     * @param int    $length
     *
     * @return ColumnDefinition
     */
    public function ulid(string $column = 'ulid', int $length = 26): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     *
     * @return ColumnDefinition
     */
    public function uuid(string $column = 'uuid'): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     *
     * @return ColumnDefinition
     */
    public function id(string $column = 'id'): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     *
     * @return ColumnDefinition
     */
    public function longText(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string   $column
     * @param int|null $precision
     *
     * @return ColumnDefinition
     */
    public function timestamp(string $column, int|null $precision = null): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     *
     * @return ColumnDefinition
     */
    public function boolean(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string   $column
     * @param int|null $precision
     *
     * @return ColumnDefinition
     */
    public function dateTime(string $column, int $precision = null): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     *
     * @return ColumnDefinition
     */
    public function ipAddress(string $column = 'ip_address'): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param string $column
     *
     * @return ColumnDefinition
     */
    public function bigIncrements(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

}
