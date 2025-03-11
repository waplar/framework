<?php

namespace Artist\Support;

use Illuminate\Support\ServiceProvider;

class AggregateServiceProvider extends ServiceProvider
{

    /**
     * 服务提供者类名称数组
     * The provider class names.
     *
     * @var array
     */
    protected array $providers = [];

    /**
     * 服务提供者实例的数组
     * An array of the service provider instances.
     *
     * @var array
     */
    protected array $instances = [];

    /**
     * 注册服务提供者
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
     * 获取服务提供者提供的服务
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
