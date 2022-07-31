<?php

namespace App\Dto\Interfaces;

/**
 * Interface DataTransferCallSetterConstraintHandlerInterface.
 *
 * @package  App\Dto\Interfaces
 *
 * @author   Codememory
 */
interface DataTransferCallSetterConstraintHandlerInterface
{
    public function handle(DataTransferConstraintInterface $constraint): bool;
}