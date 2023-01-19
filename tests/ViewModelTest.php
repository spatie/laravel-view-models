<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\ViewModels\Tests\DummyDataViewModel;
use Spatie\ViewModels\Tests\DummyViewModel;

beforeEach(function () {
    $this->viewModel = new DummyViewModel();
});

test('public methods are listed', function () {
    $array = $this->viewModel->toArray();

    expect($array)->toHaveKeys(['post', 'categories']);
});

test('public properties are listed', function () {
    $array = $this->viewModel->toArray();

    expect($array)->toHaveKey('property');
});

test('values are kept as they are', function () {
    $array = $this->viewModel->toArray();

    expect($array['post']->title)->toEqual('title');
});

test('callables can be stored', function () {
    $array = $this->viewModel->toArray();

    expect($array['callableMethod']('foo'))->toEqual('foo');
});

test('ignored methods are not listed', function () {
    $array = $this->viewModel->toArray();

    expect($array)->not->toHaveKey('ignoredMethod');
});

test('to array is not listed', function () {

    $array = $this->viewModel->toArray();

    expect($array)->not->toHaveKey('toArray');
});

test('to response is not listed', function () {
    $array = $this->viewModel->toArray();

    expect($array)->not->toHaveKey('toResponse');
});

test('magic methods are not listed', function () {
    $array = $this->viewModel->toArray();

    expect($array)->not->toHaveKey('__construct');
});

test('to response returns json by default', function () {
    $response = $this->viewModel->toResponse($this->createRequest());

    expect($response)->toBeInstanceOf(JsonResponse::class);

    $array = $this->getResponseBody($response);

    expect($array)->toHaveKeys(['post', 'categories']);
});

it('will return a regular view when a view is set and a JSON response is not requested', function () {
    $response = $this->viewModel->view('test')->toResponse($this->createRequest());

    expect($response)->toBeInstanceOf(Response::class);
});

it('will return a JSON response if a JSON response is requested even if a view is set', function () {
    $response = $this->viewModel->view('test')->toResponse($this->createRequest([
        'Accept' => 'application/json',
    ]));

    expect($response)->toBeInstanceOf(JsonResponse::class);
});

it('will allow params to be passed to view method', function () {
    $array = $this->viewModel->view('test', ['name' => 'james'])->toArray();

    expect($array)->toHaveKey('name');
});

it('will not duplicate the data attribute', function () {
    $array = (new DummyDataViewModel(['orange', 'apples']))
        ->view('test', ['name' => 'james'])->toArray();

    expect($array)->toHaveKeys(['name', 'data'])
        ->and($array['data'])->toEqual(['orange', 'apples']);
});
