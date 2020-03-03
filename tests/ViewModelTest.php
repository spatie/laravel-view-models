<?php

namespace Spatie\ViewModels\Tests;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ViewModelTest extends TestCase
{
    /** @var \Spatie\ViewModels\ViewModel */
    protected $viewModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->viewModel = new DummyViewModel();
    }

    /** @test */
    public function public_methods_are_listed()
    {
        $array = $this->viewModel->toArray();

        $this->assertArrayHasKey('post', $array);
        $this->assertArrayHasKey('categories', $array);
    }

    /** @test */
    public function public_properties_are_listed()
    {
        $array = $this->viewModel->toArray();

        $this->assertArrayHasKey('property', $array);
    }

    /** @test */
    public function values_are_kept_as_they_are()
    {
        $array = $this->viewModel->toArray();

        $this->assertEquals('title', $array['post']->title);
    }

    /** @test */
    public function callables_can_be_stored()
    {
        $array = $this->viewModel->toArray();

        $this->assertEquals('foo', $array['callableMethod']('foo'));
    }

    /** @test */
    public function ignored_methods_are_not_listed()
    {
        $array = $this->viewModel->toArray();

        $this->assertArrayNotHasKey('ignoredMethod', $array);
    }

    /** @test */
    public function to_array_is_not_listed()
    {
        $array = $this->viewModel->toArray();

        $this->assertArrayNotHasKey('toArray', $array);
    }

    /** @test */
    public function to_response_is_not_listed()
    {
        $array = $this->viewModel->toArray();

        $this->assertArrayNotHasKey('toResponse', $array);
    }

    /** @test */
    public function magic_methods_are_not_listed()
    {
        $array = $this->viewModel->toArray();

        $this->assertArrayNotHasKey('__construct', $array);
    }

    /** @test */
    public function to_response_returns_json_by_default()
    {
        $response = $this->viewModel->toResponse($this->createRequest());

        $this->assertInstanceOf(JsonResponse::class, $response);

        $array = $this->getResponseBody($response);

        $this->assertArrayHasKey('post', $array);
        $this->assertArrayHasKey('categories', $array);
    }

    /** @test */
    public function it_will_return_a_regular_view_when_a_view_is_set_and_a_json_response_is_not_requested()
    {
        $response = $this->viewModel->view('test')->toResponse($this->createRequest());

        $this->assertInstanceOf(Response::class, $response);
    }

    /** @test */
    public function it_will_return_a_json_response_if_a_json_response_is_requested_even_if_a_view_is_set()
    {
        $response = $this->viewModel->view('test')->toResponse($this->createRequest([
            'Accept' => 'application/json',
        ]));

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
