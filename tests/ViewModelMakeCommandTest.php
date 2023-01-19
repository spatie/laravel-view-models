<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\assertTrue;

it('can create a view model', function () {
    $exitCode = Artisan::call('make:view-model', [
        'name' => 'HomeViewModel',
        '--force' => true,
    ]);

    expect($exitCode)->toEqual(0)
        ->and(Artisan::output())->toMatch('~ViewModel( \[.+\])? created successfully~');

    $shouldOutputFilePath = $this->app['path'] . '/ViewModels/HomeViewModel.php';

    assertTrue(File::exists($shouldOutputFilePath), 'File exists in default app/ViewModels folder');

    expect(File::get($shouldOutputFilePath))
        ->toContain('namespace App\ViewModels;')
        ->toContain('class HomeViewModel extends ViewModel');
});

it('can create a view model with a custom namespace', function () {
    $exitCode = Artisan::call('make:view-model', [
        'name' => 'Blog/PostsViewModel',
        '--force' => true,
    ]);

    expect($exitCode)->toEqual(0)
        ->and(Artisan::output())->toMatch('~ViewModel( \[.+\])? created successfully~');

    $shouldOutputFilePath = $this->app['path'] . '/ViewModels/Blog/PostsViewModel.php';

    assertTrue(File::exists($shouldOutputFilePath), 'File exists in custom app/Blog folder');

    expect(File::get($shouldOutputFilePath))
        ->toContain('namespace App\ViewModels\Blog;')
        ->toContain('class PostsViewModel extends ViewModel');
});
