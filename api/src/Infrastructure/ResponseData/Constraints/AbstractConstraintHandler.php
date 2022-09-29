<?php

namespace App\Infrastructure\ResponseData\Constraints;

use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;

abstract class AbstractConstraintHandler implements ConstraintHandlerInterface
{
    protected ?ResponseDataInterface $responseData = null;
    protected ?EntityInterface $entityIteration = null;

    public function setResponseData(ResponseDataInterface $responseData): self
    {
        $this->responseData = $responseData;

        return $this;
    }

    public function setEntityIteration(EntityInterface $entity): self
    {
        $this->entityIteration = $entity;

        return $this;
    }
}