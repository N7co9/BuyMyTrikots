<?php

namespace App\Core\Redirect;

class RedirectSpy
{
    public array $capturedHeaders = [];

    public function sendHeader(string $header)
    {
        $this->capturedHeaders[] = $header;
    }
}