<?php

namespace App\Infrastructure\ResponseData\Interfaces;

use App\Infrastructure\ResponseData\Repository\PropertyMethodRepository;

interface PropertyDataDeterminantInterface
{
    public function getPropertyMethodRepository(): ?PropertyMethodRepository;

    public function setPropertyMethodRepository(PropertyMethodRepository $propertyMethodRepository): self;

    public function getPropertyName(): ?string;

    public function setPropertyName(string $name): self;

    public function getPropertyNameInResponse(): ?string;

    public function setPropertyNameInResponse(string $name): self;

    public function getPropertyValue(): mixed;

    public function setPropertyValue(mixed $value): self;

    public function getDefaultPropertyValue(): mixed;

    public function setDefaultPropertyValue(mixed $value): self;
}