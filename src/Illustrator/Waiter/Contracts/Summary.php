<?php

namespace Illustrator\Waiter\Contracts;

/**
 * Summary interface
 */
interface Summary
{

    /**
     * Gets meta information for all columns
     *
     * @return array
     */
    public function getMetas(): array;

    /**
     * Gets meta information for the specified column
     *
     * @param string $column
     *
     * @return array
     */
    public function getMeta(string $column): array;

}
