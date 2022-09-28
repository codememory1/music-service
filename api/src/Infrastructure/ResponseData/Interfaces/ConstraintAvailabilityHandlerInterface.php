<?php

namespace App\Infrastructure\ResponseData\Interfaces;

interface ConstraintAvailabilityHandlerInterface extends ConstraintHandlerInterface
{
    public function handle(ConstraintInterface $constraint): bool;
}