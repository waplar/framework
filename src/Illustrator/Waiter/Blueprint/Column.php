<?php

namespace Illustrator\Waiter\Blueprint;

use Illustrator\Waiter\Schema\ColumnDefinition;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;

trait Column
{

    /**
     * Create a new integer (4-byte) column on the table.
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     * @param  bool    $unsigned
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
     * Create a new big integer (8-byte) column on the table.
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
     * @param  bool    $unsigned
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
     * @param  string  $column
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
     * Create a new text column on the table.
     *
     * @param  string  $column
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
     * Create a new string column on the table.
     *
     * @param  string    $column
     * @param  int|null  $length
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
     * Create a new unsigned big integer (8-byte) column on the table.
     *
     * @param  string  $column
     * @param  bool    $autoIncrement
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
     * Create a new ULID column on the table.
     *
     * @param  string  $column
     * @param  int     $length
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
     * Create a new UUID column on the table.
     *
     * @param  string  $column
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
     * Create a new auto-incrementing big integer (8-byte) column on the table.
     *
     * @param  string  $column
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
     * Create a new long text column on the table.
     *
     * @param  string  $column
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
     * Create a new timestamp column on the table.
     *
     * @param  string    $column
     * @param  int|null  $precision
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
     * Create a new boolean column on the table.
     *
     * @param  string  $column
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
     * Create a new date-time column on the table.
     *
     * @param  string    $column
     * @param  int|null  $precision
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
     * Create a new IP address column on the table.
     *
     * @param  string  $column
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
     * Create a new auto-incrementing big integer (8-byte) column on the table.
     *
     * @param  string  $column
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

    /**
     * Create a new binary column on the table.
     *
     * @param  string    $column
     * @param  int|null  $length
     * @param  bool      $fixed
     *
     * @return ColumnDefinition
     */
    public function binary(string $column, int $length = null, bool $fixed = false): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new char column on the table.
     *
     * @param  string    $column
     * @param  int|null  $length
     *
     * @return ColumnDefinition
     */
    public function char(string $column, int $length = null): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new date-time column (with time zone) on the table.
     *
     * @param  string    $column
     * @param  int|null  $precision
     *
     * @return ColumnDefinition
     */
    public function dateTimeTz(string $column, int $precision = null): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new date column on the table.
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function date(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new decimal column on the table.
     *
     * @param  string  $column
     * @param  int     $total
     * @param  int     $places
     *
     * @return ColumnDefinition
     */
    public function decimal(string $column, int $total = 8, int $places = 2): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new double column on the table.
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function double(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new enum column on the table.
     *
     * @param  string  $column
     * @param  array   $allowed
     *
     * @return ColumnDefinition
     */
    public function enum(string $column, array $allowed): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new float column on the table.
     *
     * @param  string  $column
     * @param  int     $precision
     *
     * @return ColumnDefinition
     */
    public function float(string $column, int $precision = 53): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new medium text column on the table.
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function mediumText(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new json column on the table.
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function json(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new time column on the table.
     *
     * @param  string    $column
     * @param  int|null  $precision
     *
     * @return ColumnDefinition
     */
    public function time(string $column, int $precision = null): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new timestamp (with timezone) column on the table.
     *
     * @param  string    $column
     * @param  int|null  $precision
     *
     * @return ColumnDefinition
     */
    public function timestampTz(string $column, int $precision = null): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new geometry column on the table.
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function geometry(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new point column on the table.
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function point(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new polygon column on the table.
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function polygon(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new MAC address column on the table.
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function macAddress(string $column = 'mac_address'): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Create a new auto-incrementing medium integer (3-byte) column on the table.
     *
     * @param  string  $column
     *
     * @return ColumnDefinition
     */
    public function mediumIncrements(string $column): ColumnDefinition
    {
        return $this->addColumn(
            __FUNCTION__,
            $column,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

}
