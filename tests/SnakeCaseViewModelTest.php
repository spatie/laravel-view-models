<?php

use Illuminate\Http\JsonResponse;
use Spatie\ViewModels\Tests\SnakeCaseViewModel;

beforeEach(function () {
    $this->viewModel = new SnakeCaseViewModel();
});

test('public methods are listed and mapped as snake case', function () {
    $array = $this->viewModel->toArray();

    expect($array)->toHaveKeys(['published_post', 'available_categories']);
});

test('public properties are listed and mapped as snake case', function () {
    $array = $this->viewModel->toArray();

    expect($array)->toHaveKey('dummy_property');
});

test('values are kept as they are', function () {
    $array = $this->viewModel->toArray();

    expect($array['published_post']->title)->toEqual('title');
});

test('callables can be stored', function () {
    $array = $this->viewModel->toArray();

    expect($array['callable_method']('foo'))->toEqual('foo');
});

test('to response returns json by default', function () {
    $response = $this->viewModel->toResponse(createRequest());

    expect($response)->toBeInstanceOf(JsonResponse::class);

    $array = getResponseBody($response);

    expect($array)->toHaveKeys(['published_post', 'available_categories']);
});
