<?php

namespace App\Annotation\Interfaces;

/**
 * Interface MethodAnnotationInterface.
 *
 * @package  App\Annotation\Interfaces
 *
 * @author   Codememory
 */
interface MethodAnnotationHandlerInterface
{
    public function handle(MethodAnnotationInterface $annotation): void;
}