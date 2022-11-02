<?php

namespace App\Infrastucture\Dto\Interfaces;

use ReflectionProperty;

interface DataTransferConstraintHandlerInterface
{
    public function setDataTransfer(DataTransferInterface $dataTransfer): self;

    public function setReflectionProperty(ReflectionProperty $reflectionProperty): self;
}