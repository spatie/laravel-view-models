<?php

namespace Spatie\ViewModels\Tests\Fake;

use Spatie\ViewModels\ViewModel;
use stdClass;

class DummyViewModel extends ViewModel
{
    public string $property = 'abc';

    protected array $ignore = ['ignoredMethod'];

    public function __construct()
    {
        // This one is here for testing purposes
    }

    public function post(): stdClass
    {
        return (object) [
            'title' => 'title',
            'body' => 'body',
        ];
    }

    public function categories(): array
    {
        return [
            (object) [
                'name' => 'category A',
            ],
            (object) [
                'name' => 'category B',
            ],
        ];
    }

    public function ignoredMethod(): bool
    {
        return true;
    }

    public function callableMethod(string $name): string
    {
        return $name;
    }
}
