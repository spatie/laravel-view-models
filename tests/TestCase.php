<?php

namespace Spatie\ViewModel\Tests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Symfony\Component\HttpFoundation\Response;

class TestCase extends OrchestraTestCase
{
    protected function setUp()
    {
        parent::setUp();

        View::addLocation(__DIR__.'/resources/views');
    }

    protected function createRequest(array $headers = []): Request
    {
        $request = Request::create('/', 'GET', [], [], [], [], []);

        foreach ($headers as $header => $value) {
            $request->headers->set($header, $value);
        }

        return $request;
    }

    protected function getResponseBody(Response $response): array
    {
        return json_decode(json_decode($response->getContent(), true), true);
    }
}
