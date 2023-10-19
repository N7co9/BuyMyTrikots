<?php

namespace App\Core\Redirect;

interface RedirectInterface
{
    public function to(string $location): void;
}