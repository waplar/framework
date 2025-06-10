<?php

namespace Illustrator;

use Illuminate\Support\ServiceProvider;

class WaplarServiceProvider extends ServiceProvider
{

    /**
     * The provider class names.
     *
     * @var array
     */
    protected array $providers = [
        Waiter\WaiterServiceProvider::class,
    ];

    /**
     * An array of the service provider instances.
     *
     * @var array
     */
    protected array $instances = [];

    /**
     * Register service
     */
    public function register(): void
    {
        $this->registerProviders();
        $this->registerFacades();
    }

    /**
     * 引导服务（服务启动时执行）
     * Bootstrap service
     */
    public function boot(): void
    {
        $this->publishes([
            dirname(__DIR__, 2) . '/config/waplar.php' => config_path('waplar.php'),
            dirname(__DIR__, 2) . '/illustrator/waiter/basic_use_cases.php' => waiter_path("basic_use_cases.php"),
        ], ['waplar', 'waplar-config']);
    }

    /**
     * 注册服务提供者
     * Register service provider
     */
    protected function registerProviders(): void
    {
        collect($this->providers)->map(function (string $provider) {
            $this->app->register($provider);
        });
    }

    /**
     * Register facades
     */
    protected function registerFacades(): void
    {
        $this->app->bind(Support\Facades\Poet::FACADE_ACCESSOR, function () {
            return new Poet\Builder(
                config('waplar.poet.styles'),
                config('waplar.poet.config')
            );
        });
    }

}
