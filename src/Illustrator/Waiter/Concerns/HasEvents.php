<?php

namespace Illustrator\Waiter\Concerns;

use Closure;

trait HasEvents
{

    /**
     * Register a creating model event with the dispatcher.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function creating(Closure $callback): void
    {
        parent::creating(static::buildHasEvents($callback));
    }

    /**
     * Register a created model event with the dispatcher.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function created(Closure $callback): void
    {
        parent::created(static::buildHasEvents($callback));
    }

    /**
     * Register a retrieved model event with the dispatcher.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function retrieved(Closure $callback): void
    {
        parent::retrieved(static::buildHasEvents($callback));
    }

    /**
     * Register a saving model event with the dispatcher.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function saving(Closure $callback): void
    {
        parent::saving(static::buildHasEvents($callback));
    }

    /**
     * Register a saved model event with the dispatcher.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function saved(Closure $callback): void
    {
        parent::saved(static::buildHasEvents($callback));
    }

    /**
     * Register an updating model event with the dispatcher.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function updating(Closure $callback): void
    {
        parent::updating(static::buildHasEvents($callback));
    }

    /**
     * Register an updated model event with the dispatcher.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function updated(Closure $callback): void
    {
        parent::updated(static::buildHasEvents($callback));
    }

    /**
     * Register a replicating model event with the dispatcher.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function replicating(Closure $callback): void
    {
        parent::replicating(static::buildHasEvents($callback));
    }

    /**
     * Register a deleting model event with the dispatcher.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function deleting(Closure $callback): void
    {
        parent::deleting(static::buildHasEvents($callback));
    }

    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function deleted(Closure $callback): void
    {
        parent::deleted(static::buildHasEvents($callback));
    }

    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param Closure $callback
     *
     * @return Closure
     */
    private static function buildHasEvents(Closure $callback): Closure
    {
        return function (self $model) use ($callback) {
            return $callback($model, $model->summary);
        };
    }

}
