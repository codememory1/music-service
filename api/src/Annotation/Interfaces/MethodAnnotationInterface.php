<?php

namespace App\Annotation\Interfaces;

/**
 * Interface MethodAnnotationInterface.
 *
 * @package  App\Annotation\Interfaces
 *
 * @author   Codememory
 */
interface MethodAnnotationInterface
{
    public function getHandler(): string;
}