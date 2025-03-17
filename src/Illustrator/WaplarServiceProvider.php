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
     * Bootstrap service
     */
    public function boot(): void
    {
        $this->publishes([
            dirname(__DIR__, 2) . '/config/waplar.php' => config_path('waplar.php'),
        ], ['waplar', 'waplar-config']);
    }

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
