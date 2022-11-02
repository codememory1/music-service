<?php

namespace App\Infrastucture\Dto\Interfaces;

interface DataTransferConstraintInterface
{
    public function getHandler(): ?string;
}