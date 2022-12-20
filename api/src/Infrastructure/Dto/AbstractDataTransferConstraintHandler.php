<?php

namespace App\Infrastructure\Dto;

use App\Infrastructure\Dto\Interfaces\DataTransferConstraintHandlerInterface;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use JetBrains\PhpStorm\Pure;
use ReflectionProperty;
use ReflectionType;

abstract class AbstractDataTransferConstraintHandler implements DataTransferConstraintHandlerInterface
{
    private ?DataTransferInterface $dataTransfer = null;
    private ?ReflectionProperty $reflectionProperty = null;
    private ?string $propertyNameAsInputName = null;
    private mixed $propertyValue = null;

    public function getDataTransfer(): ?DataTransferInterface
    {
        return $this->dataTransfer;
    }

    public function setDataTransfer(DataTransferInterface $dataTransfer): self
    {
        $this->dataTransfer = $dataTransfer;

        return $this;
    }

    public function getReflectionProperty(): ?ReflectionProperty
    {
        return $this->reflectionProperty;
    }

    public function setReflectionProperty(ReflectionProperty $reflectionProperty): self
    {
        $this->reflectionProperty = $reflectionProperty;

        return $this;
    }

    #[Pure]
    public function getPropertyName(): ?string
    {
        return $this->getReflectionProperty()?->getName();
    }

    #[Pure]
    public function getPropertyType(): ?ReflectionType
    {
        return $this->getReflectionProperty()?->getType();
    }

    #[Pure]
    public function getPropertyTypeName(): ?string
    {
        return $this->getReflectionProperty()?->getType()?->getName();
    }

    public function getPropertyNameAsInputName(): ?string
    {
        return $this->propertyNameAsInputName;
    }

    public function setPropertyNameAsInputName(string $name): DataTransferConstraintHandlerInterface
    {
        $this->propertyNameAsInputName = $name;

        return $this;
    }

    public function getPropertyValue(): mixed
    {
        return $this->propertyValue;
    }

    public function setPropertyValue(mixed $value): DataTransferConstraintHandlerInterface
    {
        $this->propertyValue = $value;

        return $this;
    }
}