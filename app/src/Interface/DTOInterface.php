<?php

namespace App\Interface;

use App\Interface\EntityInterface;

/**
 * Interface DTOInterface
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
interface DTOInterface
{

    /**
     * @param EntityInterface[] $entities
     * @param array             $exclude
     *
     * @return array
     */
    public function transform(array $entities, array $exclude = []): array;

}