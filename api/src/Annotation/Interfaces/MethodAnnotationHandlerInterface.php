<?php

namespace App\Annotation\Interfaces;

interface MethodAnnotationHandlerInterface
{
    public function handle(MethodAnnotationInterface $annotation): void;
}