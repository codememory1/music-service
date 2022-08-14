<?php

namespace App\ResponseData\Interfaces;

interface ConstraintHandlerInterface
{
    public function handle(ConstraintInterface $constraint): bool;
}