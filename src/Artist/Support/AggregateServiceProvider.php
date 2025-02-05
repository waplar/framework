<?php

namespace Artist\Support;

use Illuminate\Support\ServiceProvider;

class AggregateServiceProvider extends ServiceProvider
{

    /**
     * The provider class names.
     *
     * @var array
     */
    protected array $providers = [];

    /**
     * An array of the service provider instances.
     *
     * @var array
     */
    protected array $instances = [];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->instances = [];

        foreach ($this->providers as $provider) {
            $this->instances[] = $this->app->register($provider);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        $provides = [];

        foreach ($this->providers as $provider) {
            $instance = $this->app->resolveProvider($provider);

            $provides = array_merge($provides, $instance->provides());
        }

        return $provides;
    }

}
