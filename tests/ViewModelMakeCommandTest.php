<?php

namespace Spatie\ViewModels\Tests;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use Illuminate\Support\Facades\Artisan;
use Spatie\ViewModels\Tests\Fakes\FakeViewModelMakeCommand;

class ViewModelMakeCommandTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('app'));
        FakeViewModelMakeCommand::setDirectory(vfsStream::url('app'));
    }

    /** @test */
    public function can_create_a_view_model_in_the_default_directory()
    {
        Artisan::call('make:fake-view-model', [
            'name' => 'RealViewModel'
        ]);

        $generatedClassPath = FakeViewModelMakeCommand::getDirectory() . '/ViewModels/RealViewModel.php';
        $this->assertFileExists($generatedClassPath);
        $this->assertFileIsReadable($generatedClassPath);
    }

    /** @test */
    public function can_create_a_view_model_in_a_custom_directory()
    {
        Artisan::call('make:fake-view-model', [
            'name' => 'Custom\\RealViewModel'
        ]);

        $generatedClassPath = FakeViewModelMakeCommand::getDirectory() . '/Custom/RealViewModel.php';
        $this->assertFileExists($generatedClassPath);
        $this->assertFileIsReadable($generatedClassPath);
    }
}
