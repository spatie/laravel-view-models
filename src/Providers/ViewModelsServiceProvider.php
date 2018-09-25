<?php

namespace Spatie\ViewModels\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\ViewModels\Commands\ViewModelMakeCommand;

class ViewModelsServiceProvider extends ServiceProvider
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
                ViewModelMakeCommand::class,
            ]);
        }
    }
}