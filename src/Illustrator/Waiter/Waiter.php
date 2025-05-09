<?php

namespace Illustrator\Waiter;

use Closure;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Illustrator\Foundation\Waiter\Hook\Migration as MigrationHook;
use Illustrator\Waiter\Schema\ModelDefinition;
use Laravel\SerializableClosure\SerializableClosure;

class Waiter
{

    /**
     * Build parameter information
     *
     * @var Fluent
     */
    public Fluent $params;

    /**
     * Construct a Waiter instance
     *
     * @param Fluent $params
     */
    private function __construct(Fluent $params)
    {
        $this->params = $params;
    }

    /**
     * Configure
     *
     * @return static
     */
    public static function configure(): static
    {
        $params = new Fluent();

        // Builder configuration information
        $params->set(Constants\Waiter::CONFIGURE, [
            Constants\Waiter::SUMMARY => [
                'namespace' => 'App\\Illustrator\\Waiter\\Summaries',
                'filepath' => app_path(implode(DIRECTORY_SEPARATOR, ['Illustrator', 'Waiter', 'Summaries'])),
                'suffix' => [
                    'file' => 'php',
                    'class' => 'Summary',
                ],
            ],
            Constants\Waiter::MODEL => [
                'namespace' => 'App\\Illustrator\\Waiter\\Models',
                'filepath' => app_path(implode(DIRECTORY_SEPARATOR, ['Illustrator', 'Waiter', 'Models'])),
                'suffix' => [
                    'file' => 'php',
                    'class' => 'Model',
                ],
            ],
            Constants\Waiter::MIGRATION => [
                'filepath' => database_path(implode(DIRECTORY_SEPARATOR, ['migrations', 'illustrator', 'waiter'])),
                'suffix' => [
                    'file' => 'php',
                ],
            ],
        ]);

        return new static($params);
    }

    /**
     * Configuration table information
     *
     * @param string $name
     * @param string $comment
     * @param string $prefix
     *
     * @return static
     */
    public function withTable(string $name, string $comment = '', string $prefix = ''): static
    {
        $name = Str::of($name)->matchAll('/\b[a-zA-Z_]+\b/')->join('');

        // Generate the recommended namespace and class name based on the table name
        [$classname, $namespace] = $this->resolveClassFromTable($name);

        $this->params->set(
            Constants\Waiter::TABLE,
            compact('name', 'comment', 'prefix', 'classname', 'namespace')
        );

        return $this;
    }

    /**
     * Configuration summary information
     *
     * @param string|null $namespace
     * @param string|null $classname
     * @param string|null $comment
     *
     * @return static
     */
    public function withSummary(string $namespace = null, string $classname = null, string $comment = null): static
    {
        $this->params->set(
            Constants\Waiter::SUMMARY,
            compact('namespace', 'classname', 'comment')
        );

        return $this;
    }

    /**
     * Configuration model information
     *
     * @param string      $extends
     * @param string|null $namespace
     * @param string|null $classname
     * @param string|null $comment
     * @param array       $use
     *
     * @return static
     */
    public function withModel(
        string $extends,
        string $namespace = null,
        string $classname = null,
        string $comment = null,
        array $use = []
    ): static {
        $params = $this->params->collect(Constants\Waiter::MODEL) ?? [];

        $this->params->set(Constants\Waiter::MODEL, [
            ...compact('extends', 'namespace', 'classname', 'comment', 'use'),
            ...$params,
        ]);

        return $this;
    }

    /**
     * Configuration migration information
     *
     * @param string|null $filename
     * @param string|null $comment
     * @param string      $hook
     *
     * @return static
     */
    public function withMigration(
        string $filename = null,
        string $comment = null,
        string $hook = MigrationHook::class
    ): static {
        $this->params->set(
            Constants\Waiter::MIGRATION,
            compact('filename', 'comment', 'hook')
        );

        return $this;
    }

    /**
     * Configuration model definition information
     *
     * @param ModelDefinition $definition
     *
     * @return static
     */
    public function withModelDefinition(Schema\ModelDefinition $definition): static
    {
        $params = $this->params->collect(Constants\Waiter::MODEL) ?? [];

        $this->params->set(Constants\Waiter::MODEL, [
            ...compact('definition'),
            ...$params,
        ]);

        return $this;
    }

    /**
     * Configuration blueprint information
     *
     * @param Closure $closure
     *
     * @return static
     */
    public function withBlueprint(Closure $closure): static
    {
        $closure = serialize(new SerializableClosure($closure));

        $this->params->set(
            Constants\Waiter::BLUEPRINT,
            compact('closure')
        );

        return $this;
    }

    /**
     * Generate the namespace and class name from the table name
     *
     * @param string $tableName
     *
     * @return array
     */
    private function resolveClassFromTable(string $tableName): array
    {
        $table = Str::of($tableName)->explode('_');

        if ($table->count() === 0) {
            return [Str::of($tableName)->toString(), ''];
        }

        if ($table->count() <= 2) {
            return [Str::of($tableName)->studly()->toString(), ''];
        }

        $classname = Str::of($table->take(-2)->implode('_'))->studly()->toString();
        $namespace = $table->slice(0, $table->count() - 2)->map(function (string $str) {
            return Str::of($str)->studly();
        })->implode('\\');

        return [$classname, $namespace];
    }

}
