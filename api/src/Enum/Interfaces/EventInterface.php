<?php

namespace App\Enum\Interfaces;

use UnitEnum;

/**
 * Interface EventInterface.
 *
 * @package  App\Enum\Interfaces
 *
 * @author   Codememory
 */
interface EventInterface extends UnitEnum, StringBackedEnumInterface
{
    public function getNamespaceSchema(): ?string;
}