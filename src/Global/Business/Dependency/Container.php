<?php

declare(strict_types=1);

namespace App\Global\Business\Dependency;

class Container
{
    private array $object = [];

    public function set(string $class, object $object): void
    {
        $this->object[$class] = $object;
    }

    public function get(string $class): object
    {
        return $this->object[$class];
    }

    public function getList(): array
    {
        foreach ($this->object as $item)
        {
            $array [] = $item;
        }
        return $array;
    }
}

// core
// presentation global?