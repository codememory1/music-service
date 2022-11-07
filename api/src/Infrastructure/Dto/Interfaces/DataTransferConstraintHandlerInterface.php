<?php

namespace App\Infrastructure\Dto\Interfaces;

use ReflectionProperty;

interface DataTransferConstraintHandlerInterface
{
    public function setDataTransfer(DataTransferInterface $dataTransfer): self;

    public function setReflectionProperty(ReflectionProperty $reflectionProperty): self;
}