<?php

namespace Spatie\ViewModels\Tests;

use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Spatie\ViewModels\Providers\ViewModelsServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__ . '/resources/views');
    }

    protected function getPackageProviders($app)
    {
        return [ViewModelsServiceProvider::class];
    }
}
