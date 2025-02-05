<?php

namespace Artist\Waiter\Abstracts;

/**
 * Summary abstract class
 */
abstract class Summary implements \Artist\Waiter\Contracts\Summary
{

    /**
     * Gets meta information for the specified column
     *
     * @param string $column
     *
     * @return array
     */
    final public function getMeta(string $column): array
    {
        return $this->getMetas()[$column] ?? [];
    }

    /**
     * Gets meta information for all columns
     *
     * @return array
     */
    abstract public function getMetas(): array;

}
