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
    /**
     * @param ConstraintInterface   $constraint
     * @param ResponseDataInterface $responseData
     * @param mixed                 $value
     *
     * @return mixed
     */
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): mixed;
}