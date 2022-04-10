<?php

namespace App\Interfaces;

/**
 * Interfaces DTOInterface.
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
interface DTOInterface
{
    /**
     * @param EntityInterface $entity
     * @param array           $excludeKeys
     *
     * @return array
     */
    public function toArray(EntityInterface $entity, array $excludeKeys = []): array;

    /**
     * @param EntityInterface[] $entities
     * @param array             $excludeKeys
     *
     * @return array
     */
    public function transform(array $entities, array $excludeKeys = []): array;

    /**
     * @param EntityInterface $entity
     *
     * @return $this
     */
    public function setEntityForBuild(EntityInterface $entity): self;

    /**
     * @return null|EntityInterface
     */
    public function getCollectedEntity(): ?EntityInterface;
}