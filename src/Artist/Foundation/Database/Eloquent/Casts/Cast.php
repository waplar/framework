<?php

namespace Artist\Foundation\Database\Eloquent\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * [Eloquent] cast abstract class
 *
 * @author KanekiYuto
 */
abstract class Cast implements CastsAttributes
{

    /**
     * 对提取的数据进行转换
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     * @param array  $attributes
     *
     * @return string
     */
    abstract public function get(Model $model, string $key, mixed $value, array $attributes): string;

    /**
     * 转换为将被存储的值
     *
     * @param Model  $model
     * @param string $key
     * @param array  $value
     * @param array  $attributes
     *
     * @return int
     */
    abstract public function set(Model $model, string $key, mixed $value, array $attributes): int;

}
