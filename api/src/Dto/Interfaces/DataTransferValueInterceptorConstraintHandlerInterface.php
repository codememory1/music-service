<?php

namespace App\Dto\Interfaces;

/**
 * Interface DataTransferValueInterceptorConstraintHandlerInterface.
 *
 * @package  App\Dto\Interfaces
 *
 * @author   Codememory
 */
interface DataTransferValueInterceptorConstraintHandlerInterface
{
    public function handle(DataTransferConstraintInterface $constraint, mixed $value): mixed;
}