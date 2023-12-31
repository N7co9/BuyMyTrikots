<?php

namespace App\Core\DTO;

class ErrorDTO
{
    public function __construct(
        public readonly string $message,
    )
    {
    }

    public function getMessage()
    {
        return $this->message;
    }
}