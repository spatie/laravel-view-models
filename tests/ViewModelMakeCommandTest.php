<?php

namespace Spatie\ViewModels\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ViewModelMakeCommandTest extends TestCase
{
    /** @test */
    public function it_can_create_a_view_model()
    {
        $exitCode = Artisan::call('make:view-model', [
            'name' => 'HomeViewModel',
            '--force' => true,
        ]);

        $this->assertEquals(0, $exitCode);

        $this->assertStringContainsString('ViewModel created successfully.', Artisan::output());

        $shouldOutputFilePath = $this->app['path'].'/ViewModels/HomeViewModel.php';

        $this->assertTrue(File::exists($shouldOutputFilePath), 'File exists in default app/ViewModels folder');

        $contents = File::get($shouldOutputFilePath);

        $this->assertStringContainsString('namespace App\ViewModels;', $contents);

        $this->assertStringContainsString('class HomeViewModel extends ViewModel', $contents);
    }

    /** @test */
    public function it_can_create_a_view_model_with_a_custom_namespace()
    {
        $exitCode = Artisan::call('make:view-model', [
            'name' => 'Blog/PostsViewModel',
            '--force' => true,
        ]);

        $this->assertEquals(0, $exitCode);

        $this->assertStringContainsString('ViewModel created successfully.', Artisan::output());

        $shouldOutputFilePath = $this->app['path'].'/Blog/PostsViewModel.php';

        $this->assertTrue(File::exists($shouldOutputFilePath), 'File exists in custom app/Blog folder');

        $contents = File::get($shouldOutputFilePath);

        $this->assertStringContainsString('namespace App\Blog;', $contents);

        $this->assertStringContainsString('class PostsViewModel extends ViewModel', $contents);
    }
}
