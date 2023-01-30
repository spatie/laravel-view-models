<?php

namespace Spatie\ViewModels\Tests;

use Spatie\ViewModels\ViewModel;
use stdClass;

class SnakeCaseViewModel extends ViewModel
{
    protected $snakeCase = true;

    public $dummyProperty = 'abc';

    protected $ignore = ['ignoredMethod'];

    public function __construct()
    {
        // This one is here for testing purposes
    }

    public function publishedPost(): stdClass
    {
        return (object) [
            'title' => 'title',
            'body' => 'body',
        ];
    }

    public function availableCategories(): array
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
