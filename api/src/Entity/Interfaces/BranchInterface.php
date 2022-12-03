<?php

namespace App\Entity\Interfaces;

interface BranchInterface
{
    public function getKey(): ?string;

    public function setKey(string $key): self;

    public function getValue(): array;

    public function setValue(array $value): self;
}