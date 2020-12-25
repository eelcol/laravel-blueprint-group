<?php

namespace Eelcol\LaravelBlueprintGroup\Tests;

use Eelcol\LaravelBlueprintGroup\BlueprintGroupServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            BlueprintGroupServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}