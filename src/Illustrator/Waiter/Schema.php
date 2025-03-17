<?php

namespace Illustrator\Waiter;

use Closure;
use Illuminate\Support\Fluent;

class Schema
{

    /**
     * Stores various parameters for interaction
     *
     * @var Fluent
     */
    private Fluent $params;

    /**
     * Construct a Schema instance
     *
     * @param string $action
     * @param string $table
     */
    public function __construct(protected string $action, protected string $table)
    {
        $this->params = new Fluent();
    }

    /**
     * Stay in line with laravel
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function table(Closure $callback): void
    {
        $this->build(__FUNCTION__, $callback);
    }

    /**
     * Stay in line with laravel
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function create(Closure $callback): void
    {
        $this->build(__FUNCTION__, $callback);
    }

    /**
     * Stay in line with laravel
     *
     * @return void
     */
    public function dropIfExists(): void
    {
        $this->params->set(__FUNCTION__, ['table' => 'TheSummary::TABLE']);
    }

    /**
     * Stay in line with laravel
     *
     * @return void
     */
    public function drop(): void
    {
        $this->params->set(__FUNCTION__, ['table' => 'TheSummary::TABLE']);
    }

    /**
     * Get these parameters
     *
     * @return Fluent
     */
    public function getParams(): Fluent
    {
        return $this->params;
    }

    /**
     * Build blueprint params
     *
     * @param string  $fn
     * @param Closure $callback
     *
     * @return void
     */
    private function build(string $fn, Closure $callback): void
    {
        $blueprint = new Blueprint($this->table, '');

        $callback($blueprint);

        $this->params->set($fn, [
            'columns' => $blueprint->getColumns(),
            'commands' => $blueprint->getCommands(),
        ]);
    }

}
