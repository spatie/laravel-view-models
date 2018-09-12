<?php

namespace Spatie\ViewModels\Tests;

use Spatie\ViewModels\ViewModel;
use stdClass;

class DummyViewModel extends ViewModel
{
    protected $ignore = ['ignoredMethod'];

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
