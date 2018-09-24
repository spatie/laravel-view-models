<?php

namespace Spatie\ViewModels\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\ViewModels\Console\ViewModelMakeCommand;

class ViewModelsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            ViewModelMakeCommand::class,
        ]);
    }
}
