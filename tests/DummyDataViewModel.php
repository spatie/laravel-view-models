<?php


namespace Spatie\ViewModels\Tests;

use Spatie\ViewModels\ViewModel;

class DummyDataViewModel extends ViewModel
{
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function data()
    {
        return $this->data;
    }
}
