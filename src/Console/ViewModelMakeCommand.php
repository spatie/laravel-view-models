<?php

namespace Spatie\ViewModels\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ViewModelMakeCommand extends GeneratorCommand
{
    protected $name = 'make:view-model';

    protected $description = 'Create a new ViewModel class';

    protected $type = 'ViewModel';

    public function handle()
    {
        if (parent::handle() === false) {
            if (! $this->option('force')) {
                return;
            }
        }
    }

    protected function getStub()
    {
        return __DIR__.'/../../stubs/DummyViewModel.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->isCustomNamespace()) {
            return $rootNamespace;
        }

        return $rootNamespace.'\ViewModels';
    }

    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the view-model already exists'],
        ];
    }

    protected function isCustomNamespace(): bool
    {
        return Str::contains($this->argument('name'), '/');
    }
}
