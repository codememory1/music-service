<?php

namespace App\Infrastructure\ResponseData\Interfaces;

interface ConstraintInterface
{
    public function getHandler(): string;
}