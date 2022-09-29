<?php

namespace App\Infrastructure\ResponseData\Repository;

use function Symfony\Component\String\u;

final class PropertyMethodRepository
{
    public function __construct(
        private string $prefix,
        private string $name
    ) {
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changePrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function changeName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMethodName(): string
    {
        return u("{$this->prefix}_{$this->name}")->camel()->toString();
    }
}