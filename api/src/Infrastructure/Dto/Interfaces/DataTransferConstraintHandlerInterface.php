<?php

namespace App\Infrastructure\Dto\Interfaces;

use ReflectionProperty;

interface DataTransferConstraintHandlerInterface
{
    public function setDataTransfer(DataTransferInterface $dataTransfer): self;

    public function setReflectionProperty(ReflectionProperty $reflectionProperty): self;

    public function getPropertyNameAsInputName(): ?string;

    public function setPropertyNameAsInputName(string $name): self;

    public function getPropertyValue(): mixed;

    public function setPropertyValue(mixed $value): self;
}