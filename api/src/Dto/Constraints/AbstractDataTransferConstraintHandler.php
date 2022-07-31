<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintHandlerInterface;
use App\Dto\Interfaces\DataTransferInterface;
use JetBrains\PhpStorm\Pure;
use ReflectionProperty;
use ReflectionType;

/**
 * Class AbstractDataTransferConstraintHandler.
 *
 * @package App\Dto\Constraints
 *
 * @author  Codememory
 */
abstract class AbstractDataTransferConstraintHandler implements DataTransferConstraintHandlerInterface
{
    private ?DataTransferInterface $dataTransfer = null;
    private ?ReflectionProperty $reflectionProperty = null;

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
}