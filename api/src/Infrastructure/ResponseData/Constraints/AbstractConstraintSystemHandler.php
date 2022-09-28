<?php

namespace App\Infrastructure\ResponseData\Constraints;

use App\Infrastructure\Repository\PropertyMethodRepository;
use App\Infrastructure\ResponseData\Interfaces\ConstraintSystemHandlerInterface;

abstract class AbstractConstraintSystemHandler extends AbstractConstraintHandler implements ConstraintSystemHandlerInterface
{
    protected ?PropertyMethodRepository $propertyMethodRepository = null;
    protected ?string $propertyName = null;
    protected ?string $propertyNameInResponse = null;
    protected bool $isAllowed = true;

    public function setPropertyMethodRepository(PropertyMethodRepository $propertyMethodRepository): self
    {
        $this->propertyMethodRepository = $propertyMethodRepository;

        return $this;
    }

    public function setPropertyName(string $name): self
    {
        $this->propertyName = $name;

        return $this;
    }

    public function setPropertyNameInResponse(string $name): self
    {
        $this->propertyNameInResponse = $name;

        return $this;
    }

    public function setIsAllowed(bool $isAllowed): self
    {
        $this->isAllowed = $isAllowed;

        return $this;
    }
}