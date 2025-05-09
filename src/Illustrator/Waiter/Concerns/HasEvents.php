<?php

namespace Illustrator\Waiter\Concerns;

use Closure;

trait HasEvents
{

    /**
     * Register a creating model event with the dispatcher.
     *
     * @param  callable  $callback
     *
     * @return void
     */
    public static function creating($callback)
    {
        parent::creating(static::buildHasEvents($callback));
    }

    /**
     * Register a created model event with the dispatcher.
     *
     * @param  callable  $callback
     *
     * @return void
     */
    public static function created($callback)
    {
        parent::created(static::buildHasEvents($callback));
    }

    /**
     * Register a retrieved model event with the dispatcher.
     *
     * @param  callable  $callback
     *
     * @return void
     */
    public static function retrieved($callback)
    {
        parent::retrieved(static::buildHasEvents($callback));
    }

    /**
     * Register a saving model event with the dispatcher.
     *
     * @param  callable  $callback
     *
     * @return void
     */
    public static function saving($callback)
    {
        parent::saving(static::buildHasEvents($callback));
    }

    /**
     * Register a saved model event with the dispatcher.
     *
     * @param  callable  $callback
     *
     * @return void
     */
    public static function saved($callback)
    {
        parent::saved(static::buildHasEvents($callback));
    }

    /**
     * Register an updating model event with the dispatcher.
     *
     * @param  callable  $callback
     *
     * @return void
     */
    public static function updating($callback)
    {
        parent::updating(static::buildHasEvents($callback));
    }

    /**
     * Register an updated model event with the dispatcher.
     *
     * @param  callable  $callback
     *
     * @return void
     */
    public static function updated($callback)
    {
        parent::updated(static::buildHasEvents($callback));
    }

    /**
     * Register a replicating model event with the dispatcher.
     *
     * @param  callable  $callback
     *
     * @return void
     */
    public static function replicating($callback)
    {
        parent::replicating(static::buildHasEvents($callback));
    }

    /**
     * Register a deleting model event with the dispatcher.
     *
     * @param  callable  $callback
     *
     * @return void
     */
    public static function deleting($callback)
    {
        parent::deleting(static::buildHasEvents($callback));
    }

    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param  callable  $callback
     *
     * @return void
     */
    public static function deleted($callback)
    {
        parent::deleted(static::buildHasEvents($callback));
    }

    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param  callable  $callback
     *
     * @return Closure
     */
    private static function buildHasEvents($callback): Closure
    {
        return function (self $model) use ($callback) {
            return $callback($model, $model->summary);
        };
    }

}
