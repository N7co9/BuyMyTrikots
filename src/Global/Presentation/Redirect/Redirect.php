<?php

namespace App\Global\Presentation\Redirect;
#Redirect

class Redirect implements RedirectInterface
{
    private string $url = 'http://localhost:8000/';

    public function to(string $location): void
    {
        header('Location: ' . $this->url . $location);
    }
}