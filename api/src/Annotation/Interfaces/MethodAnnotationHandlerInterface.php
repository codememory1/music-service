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
    /**
     * @param MethodAnnotationInterface $annotation
     *
     * @return void
     */
    public function handle(MethodAnnotationInterface $annotation): void;
}