<?php

namespace App\Dto\Interfaces;

/**
 * Interface DataTransferConstraintInterface.
 *
 * @package  App\Dto\Interfaces
 *
 * @author   Codememory
 */
interface DataTransferConstraintInterface
{
    public function getHandler(): ?string;
}