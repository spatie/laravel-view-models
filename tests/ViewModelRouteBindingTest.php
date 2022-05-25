<?php

namespace Spatie\ViewModels\Tests;

use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Spatie\ViewModels\Tests\Fake\RouteBoundViewModel;

class ViewModelRouteBindingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testbench']);

        User::query()->forceCreate([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('app.debug', true);
    }

    /** @test */
    public function it_binds_route_parameters_to_view_model()
    {
        Route::get('users/{user}', function (Request $request, RouteBoundViewModel $viewModel) {
            return $viewModel->toResponse($request);
        })->middleware(SubstituteBindings::class);

        $this
            ->get('/users/1', ['content-type' => 'application/json'])
            ->assertOk()
            ->assertJson([
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
            ]);
    }
}
