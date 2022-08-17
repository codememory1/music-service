<?php

namespace App\Annotation\Interfaces;

interface MethodAnnotationInterface
{
    public function getHandler(): string;
}