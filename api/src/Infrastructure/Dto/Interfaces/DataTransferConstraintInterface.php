<?php

namespace App\Infrastructure\Dto\Interfaces;

interface DataTransferConstraintInterface
{
    public function getHandler(): ?string;
}