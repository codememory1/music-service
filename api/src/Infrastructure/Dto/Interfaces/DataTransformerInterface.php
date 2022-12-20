<?php

namespace App\Infrastructure\Dto\Interfaces;

use App\Entity\Interfaces\EntityInterface;

interface DataTransformerInterface
{
    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface;

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface;
}