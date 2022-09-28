<?php

namespace App\Infrastructure\ResponseData\Interfaces;

use App\Entity\Interfaces\EntityInterface;
use Doctrine\Common\Collections\Collection;

interface ResponseDataInterface
{
    public function setEntities(EntityInterface|Collection|array $entities): self;

    public function setIgnoredProperties(array $names): self;

    public function addIgnoreProperty(string $name): self;

    public function getResponse(bool $asFirst = false): array;
}