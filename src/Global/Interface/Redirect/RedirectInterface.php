<?php

namespace App\Global\Interface\Redirect;

interface RedirectInterface
{
    public function to(string $location): void;
}