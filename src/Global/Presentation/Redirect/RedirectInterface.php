<?php

namespace App\Global\Presentation\Redirect;

interface RedirectInterface
{
    public function to(string $location): void;
}