<?php

namespace Spatie\ViewModels\Tests\Fakes;

use Illuminate\Support\ServiceProvider;

class FakeViewModelsServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FakeViewModelMakeCommand::class,
            ]);
        }
    }
}
