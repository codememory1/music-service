<?php

namespace App\Infrastructure\ResponseData\Interfaces;

use App\Entity\Interfaces\EntityInterface;
use Doctrine\Common\Collections\Collection;

interface ResponseDataInterface
{
    public function setEntities(EntityInterface|Collection|array $entities): self;

    public function setIgnoredProperties(array $propertyNames): self;

    public function addIgnoreProperty(string $propertyName): self;

    public function setOnlyProperties(array $propertyNames): self;

    public function addOnlyProperty(string $propertyName): self;

    public function getResponse(): array;
}