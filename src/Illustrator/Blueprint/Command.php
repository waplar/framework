<?php

namespace Illustrator\Blueprint;

use Illuminate\Support\Fluent;

trait Command
{

    /**
     * Stay in line with laravel
     *
     * @param string $comment
     *
     * @return Fluent
     */
    public function comment(string $comment): Fluent
    {
        return $this->addCommand(
            __FUNCTION__,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

    /**
     * Stay in line with laravel
     *
     * @param array|string $columns
     * @param string|null  $name
     * @param string|null  $algorithm
     *
     * @return Fluent
     */
    public function unique(array|string $columns, string $name = null, string $algorithm = null): Fluent
    {
        return $this->addCommand(
            __FUNCTION__,
            $this->filterDefaultsFromCaller(func_get_args())
        );
    }

}
