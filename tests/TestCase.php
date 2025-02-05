<?php

namespace Tests;

use Artist\WaplarServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    /**
     * Set up the test environment
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        AliasLoader::getInstance()->setAliases([]);
    }

    /**
     * Get package providers.
     *
     * @param  Application  $app
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            WaplarServiceProvider::class,
        ];
    }

}
