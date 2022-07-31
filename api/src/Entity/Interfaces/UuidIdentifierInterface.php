<?php

namespace App\Entity\Interfaces;

/**
 * Interface UuidIdentifierInterface.
 *
 * @package  App\Entity\Interfaces
 *
 * @author   Codememory
 */
interface UuidIdentifierInterface
{
    public function generateUuid(): self;

    public function getUuid(): ?string;
}