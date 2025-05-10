<?php

namespace Illustrator\Waiter;

use Illuminate\Support\ServiceProvider;

class WaiterServiceProvider extends ServiceProvider
{

    /**
     * Register service
     */
    public function register(): void
    {
        $this->app->singleton(Console\WaiterCommand::class, function () {
            return new Console\WaiterCommand();
        });

        $this->commands([Console\WaiterCommand::class]);
    }

    /**
     * Bootstrap service
     */
    public function boot(): void
    {
        $this->publishesTestCase();
    }

    /**
     * Publish test cases
     */
    protected function publishesTestCase(): void
    {
        $publishes = collect([
            'test_case_one',
            'test_case_two',
            'test_case_three',
            'test_case_four',
        ])->mapWithKeys(function (string $filename) {
            $key = dirname(__DIR__, 3) . "/illustrator/waiter/$filename.php";
            $value = waiter_path("$filename.php");

            return [$key => $value];
        });

        $this->publishes($publishes->all(), ['waplar', 'waplar-test', 'waplar-waiter-test-case']);
    }

}
