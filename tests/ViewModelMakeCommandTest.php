<?php

namespace Spatie\ViewModels\Tests;

use Illuminate\Support\Facades\Artisan;

class ViewModelMakeCommandTest extends TestCase
{
    /** @test */
    public function command_returns_signal_zero()
    {
        $exitCode = Artisan::call('make:view-model', [
            'name' => 'PostsViewModel',
            '--force' => true,
        ]);

        $this->assertEquals(0, $exitCode);

        $this->assertContains('ViewModel created successfully.', Artisan::output());
    }
}
