<?php

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

uses(Spatie\ViewModels\Tests\TestCase::class)->in('.');

// Functions

function createRequest(array $headers = []): Request
{
    $request = Request::create('/', 'GET', [], [], [], [], []);

    foreach ($headers as $header => $value) {
        $request->headers->set($header, $value);
    }

    return $request;
}

function getResponseBody(Response $response): array
{
    return json_decode($response->getContent(), true);
}
