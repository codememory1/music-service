<?php

namespace App\Infrastructure\ResponseData\Interfaces;

use App\Infrastructure\Repository\PropertyMethodRepository;

interface ConstraintSystemHandlerInterface extends ConstraintHandlerInterface
{
    public function setPropertyMethodRepository(PropertyMethodRepository $propertyMethodRepository): self;

    public function setPropertyName(string $name): self;

    public function setPropertyNameInResponse(string $name): self;

    public function setIsAllowed(bool $isAllowed): self;

    public function handle(): void;
}