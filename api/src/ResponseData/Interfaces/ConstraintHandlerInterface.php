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
    /**
     * @param ConstraintInterface $constraint
     *
     * @return bool
     */
    public function handle(ConstraintInterface $constraint): bool;
}