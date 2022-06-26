<?php

namespace App\ResponseData\Interfaces;

use App\Entity\Interfaces\EntityInterface;

/**
 * Interface ResponseDataInterface.
 *
 * @package  App\ResponseData\Interfaces
 *
 * @author   Codememory
 */
interface ResponseDataInterface
{
    /**
     * @param string $name
     *
     * @return $this
     */
    public function setIgnoreProperty(string $name): self;

    /**
     * @param array<EntityInterface>|EntityInterface $entities
     *
     * @return $this
     */
    public function setEntities(EntityInterface|array $entities): self;

    /**
     * @return $this
     */
    public function collect(): self;

    /**
     * @param bool $first
     *
     * @return array
     */
    public function getResponse(bool $first = false): array;
}