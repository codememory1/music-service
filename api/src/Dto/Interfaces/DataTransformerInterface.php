<?php

namespace App\Dto\Interfaces;

use App\Entity\Interfaces\EntityInterface;

/**
 * Interface DataTransformerInterface.
 *
 * @package  App\Dto\Interfaces
 *
 * @author   Codememory
 */
interface DataTransformerInterface
{
    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface;

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface;
}