<?php declare(strict_types=1);

namespace App\Core;
interface  TemplateInterface
{
    public function addParameter(string $key, mixed $value): void;

    public function display();

    public function getParameters(): array;
}