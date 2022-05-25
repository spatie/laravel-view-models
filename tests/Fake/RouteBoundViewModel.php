<?php

namespace Spatie\ViewModels\Tests\Fake;

use Illuminate\Foundation\Auth\User;
use Spatie\ViewModels\ViewModel;

class RouteBoundViewModel extends ViewModel
{
    public string $name;

    public string $email;

    public function __construct(User $user)
    {
        $this->name = $user->name;
        $this->email = $user->email;
    }
}
