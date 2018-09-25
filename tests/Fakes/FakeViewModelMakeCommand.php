<?php

namespace Spatie\ViewModels\Tests\Fakes;

use Illuminate\Support\Str;
use Spatie\ViewModels\Commands\ViewModelMakeCommand;

class FakeViewModelMakeCommand extends ViewModelMakeCommand
{
    protected $name = 'make:fake-view-model';

    public static $directory;

    public static function getDirectory()
    {
        return self::$directory;
    }

    public static function setDirectory($directory)
    {
        self::$directory = $directory;
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        if ($this->hasNamespace($name)) {
            return self::$directory.'/'.str_replace('\\', '/', $name).'.php';
        }

        return self::$directory.'/'.str_replace('\\', '/', 'ViewModels/'.$name).'.php';
    }
}
