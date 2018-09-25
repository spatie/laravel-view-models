<?php

namespace Spatie\ViewModels\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ViewModelMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:view-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view-model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View model';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return;
        }
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        if ($this->hasNamespace($name)) {
            return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
        }

        return $this->laravel['path'].'/'.str_replace('\\', '/', 'ViewModels/'.$name).'.php';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/view-model.stub';
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $namespace = $this->hasNamespace($name) ?
                    $this->getNamespace($name) :
                    $this->getNamespace($name).'\\ViewModels';

        $stub = str_replace('DummyNamespace', $namespace, $stub);

        return $this;
    }

    /**
     * Check wheter the name param has
     * namespace or not.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function hasNamespace($name)
    {
        return str_contains($name, '\\');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
        ];
    }
}
