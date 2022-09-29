<?php

namespace App\Infrastructure\ResponseData;

use App\Infrastructure\ResponseData\Interfaces\PropertyDataDeterminantInterface;
use App\Infrastructure\ResponseData\Repository\PropertyMethodRepository;

final class PropertyDataDeterminant implements PropertyDataDeterminantInterface
{
    private ?PropertyMethodRepository $propertyMethodRepository = null;
    private ?string $propertyName = null;
    private ?string $propertyNameInResponse = null;
    private mixed $propertyValue = null;
    private mixed $defaultPropertyValue = null;

    public function getPropertyMethodRepository(): ?PropertyMethodRepository
    {
        return $this->propertyMethodRepository;
    }

    public function setPropertyMethodRepository(PropertyMethodRepository $propertyMethodRepository): self
    {
        $this->propertyMethodRepository = $propertyMethodRepository;

        return $this;
    }

    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }

    public function setPropertyName(string $name): self
    {
        $this->propertyName = $name;

        return $this;
    }

    public function getPropertyNameInResponse(): ?string
    {
        return $this->propertyNameInResponse;
    }

    public function setPropertyNameInResponse(string $name): self
    {
        $this->propertyNameInResponse = $name;

        return $this;
    }

    public function getPropertyValue(): mixed
    {
        return $this->propertyValue;
    }

    public function setPropertyValue(mixed $value): self
    {
        $this->propertyValue = $value;

        return $this;
    }

    public function getDefaultPropertyValue(): mixed
    {
        return $this->defaultPropertyValue;
    }

    public function setDefaultPropertyValue(mixed $value): self
    {
        $this->defaultPropertyValue = $value;

        return $this;
    }
}