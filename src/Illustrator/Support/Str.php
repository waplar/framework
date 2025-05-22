<?php

namespace Illustrator\Support;

class Str extends \Illuminate\Support\Str
{

    /**
     * 生成列别名 SQL
     * Generate column aliases SQL
     *
     * @param string $source
     * @param string $target
     *
     * @return string
     */
    public static function columnAlias(string $source, string $target): string
    {
        return implode(' as ', [$source, $target]);
    }

    /**
     * 生成多个 ORM with 关联加载
     * Generate multiple ORMs with associated loading
     *
     * @param array $relations
     *
     * @return array
     */
    public function ormWithMany(array $relations): array
    {
        return collect($relations)->map(function ($columns, $name) {
            return $name . (!empty($columns) ? ':' . implode(',', $columns) : '');
        })->values()->toArray();
    }

}
