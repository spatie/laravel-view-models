<?php

namespace Spatie\ViewModels\Tests;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class ViewModelMakeCommandTest extends TestCase
{
    /** @test */
    public function command_returns_signal_zero()
    {
        $a = Artisan::call('make:view-model', [ 'name' => 'PostsViewModel']);

        $b = Artisan::output();

        dd($a, $b);
    }
}
