<?php

namespace App\DTO\Interfaces;

use App\Entity\Interfaces\EntityInterface;

/**
 * Interface DTOInterface.
 *
 * @package  App\DTO\Interfaces
 *
 * @author   Codememory
 */
interface DTOInterface
{
    /**
     * @param string $type
     *
     * @return $this
     */
    public function setRequestType(string $type): self;

    /**
     * @param array $propertyNames
     *
     * @return $this
     */
    public function preventSetterCallForKeys(array $propertyNames): self;

    /**
     * @param EntityInterface $entity
     *
     * @return $this
     */
    public function setEntity(EntityInterface $entity): self;

    /**
     * @return null|EntityInterface
     */
    public function getEntity(): ?EntityInterface;
}