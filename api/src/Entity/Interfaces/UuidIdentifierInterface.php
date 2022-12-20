<?php

namespace App\Entity\Interfaces;

interface UuidIdentifierInterface
{
    public function generateUuid(): self;

    public function getUuid(): ?string;
}