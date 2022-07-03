<?php

namespace App\ResponseData\Interfaces;

/**
 * Interface ValueHandlerInterface.
 *
 * @package  App\ResponseData\Interfaces
 *
 * @author   Codememory
 */
interface ValueHandlerInterface
{
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): mixed;
}