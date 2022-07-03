<?php

namespace App\ResponseData\Interfaces;

/**
 * Interface ConstraintHandlerInterface.
 *
 * @package  App\ResponseData\Interfaces
 *
 * @author   Codememory
 */
interface ConstraintHandlerInterface
{
    public function handle(ConstraintInterface $constraint): bool;
}