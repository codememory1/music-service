<?php

namespace App\ResponseData\Interfaces;

/**
 * Interface ConstraintInterface.
 *
 * @package  App\ResponseData\Interfaces
 *
 * @author   Codememory
 */
interface ConstraintInterface
{
    /**
     * @return string
     */
    public function getHandler(): string;
}