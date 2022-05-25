<?php

namespace Spatie\ViewModels\Providers;

use AidanCasey\Laravel\RouteBinding\Binder;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Spatie\ViewModels\Console\ViewModelMakeCommand;
use Spatie\ViewModels\ViewModel;

class ViewModelsServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ViewModelMakeCommand::class,
            ]);
        }

        $this->app->beforeResolving(ViewModel::class, function ($class, $parameters, Container $app) {
            if ($app->has($class)) {
                return;
            }

            $app->bind($class, fn () => Binder::make($class, $parameters));
        });
    }
}
