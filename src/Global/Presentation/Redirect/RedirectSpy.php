<?php

namespace App\Global\Presentation\Redirect;

class RedirectSpy implements RedirectInterface
{
    public string $location = '';
    public function to(string $location): void
    {
        $this->location = $location;
    }

}