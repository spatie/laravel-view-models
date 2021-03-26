<?php

namespace Spatie\ViewModels;

use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\ViewModels\Console\ViewModelMakeCommand;

class ViewModelsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-view-models')
            ->hasCommand(ViewModelMakeCommand::class);
    }
}
