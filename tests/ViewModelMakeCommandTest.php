<?php

namespace Spatie\ViewModels\Tests;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

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

        $this->assertContains('ViewModel created successfully.', Artisan::output());

        $shouldOutputFilePath = $this->app['path'].'/ViewModels/HomeViewModel.php';

        $this->assertTrue(File::exists($shouldOutputFilePath), 'File exists in default app/ViewModels folder');

        $contents = File::get($shouldOutputFilePath);

        $this->assertContains('namespace App\ViewModels;', $contents);

        $this->assertContains('class HomeViewModel extends ViewModel', $contents);
    }

    /** @test */
    public function it_can_create_a_view_model_with_a_custom_namespace()
    {
        $exitCode = Artisan::call('make:view-model', [
            'name' => 'Blog/PostsViewModel',
            '--force' => true,
        ]);

        $this->assertEquals(0, $exitCode);

        $this->assertContains('ViewModel created successfully.', Artisan::output());

        $shouldOutputFilePath = $this->app['path'].'/Blog/PostsViewModel.php';

        $this->assertTrue(File::exists($shouldOutputFilePath), 'File exists in custom app/Blog folder');

        $contents = File::get($shouldOutputFilePath);

        $this->assertContains('namespace App\Blog;', $contents);

        $this->assertContains('class PostsViewModel extends ViewModel', $contents);
    }
}
