<?php

namespace App\Infrastructure\Dto\Interfaces;

use App\Entity\Interfaces\EntityInterface;
use Codememory\Dto\Interfaces\DataTransferInterface;

interface DataTransformerInterface
{
    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface;

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface;
}