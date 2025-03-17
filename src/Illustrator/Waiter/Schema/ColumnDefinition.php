<?php

namespace Illustrator\Waiter\Schema;

use Closure;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Support\Fluent;

/**
 * 列定义参数类
 * Column defines the parameter class
 *
 * @method $this after(string $column)
 * @method $this always(bool $value = true)
 * @method $this autoIncrement()
 * @method $this change()
 * @method $this charset(string $charset)
 * @method $this collation(string $collation)
 * @method $this comment(string $comment)
 * @method $this default(mixed $value)
 * @method $this first()
 * @method $this from(int $startingValue)
 * @method $this generatedAs(string|Expression $expression = null)
 * @method $this index(bool|string $indexName = null)
 * @method $this invisible()
 * @method $this nullable(bool $value = true)
 * @method $this persisted()
 * @method $this primary(bool $value = true)
 * @method $this fulltext(bool|string $indexName = null)
 * @method $this spatialIndex(bool|string $indexName = null)
 * @method $this startingValue(int $startingValue)
 * @method $this storedAs(string|Expression $expression)
 * @method $this type(string $type)
 * @method $this unique(bool|string $indexName = null)
 * @method $this unsigned()
 * @method $this useCurrent()
 * @method $this useCurrentOnUpdate()
 * @method $this virtualAs(string|Expression $expression)
 * @method $this cast(Closure|string $value)
 * @method $this fillable(bool $value = true)
 * @method $this guarded(bool $value = true)
 * @method $this hidden(bool $value = true)
 * @method $this summary(bool $value = true)
 */
class ColumnDefinition extends Fluent
{
    //
}
