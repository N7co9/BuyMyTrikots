<?php

namespace App\Global\Business\Redirect;

use App\Global\Interface\Redirect\RedirectInterface;

class RedirectSpy implements RedirectInterface
{
    public string $location = '';
    public function to(string $location): void
    {
        $this->location = $location;
    }

}