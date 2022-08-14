<?php

namespace App\Enum\Interfaces;

use UnitEnum;

interface EventInterface extends UnitEnum, StringBackedEnumInterface
{
    public function getNamespaceSchema(): ?string;
}