<?php

namespace App\Enum\Interfaces;

interface EventInterface extends EnumInterface
{
    public function getNamespaceSchema(): ?string;
}