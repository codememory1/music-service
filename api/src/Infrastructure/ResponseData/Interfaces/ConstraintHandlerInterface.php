<?php

namespace App\Infrastructure\ResponseData\Interfaces;

use App\Entity\Interfaces\EntityInterface;

interface ConstraintHandlerInterface
{
    public function setResponseData(ResponseDataInterface $responseData): self;

    public function setEntityIteration(EntityInterface $entity): self;
}