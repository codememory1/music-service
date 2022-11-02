<?php

namespace App\Infrastructure\Doctrine;

use App\Entity\Interfaces\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

class Flusher
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    public function addRemove(EntityInterface $entity): self
    {
        $this->em->remove($entity);

        return $this;
    }

    public function remove(EntityInterface $entity): void
    {
        $this->addRemove($entity)->save();
    }

    public function addPersist(EntityInterface $entity): self
    {
        $this->em->persist($entity);

        return $this;
    }

    public function save(?EntityInterface $entity = null): void
    {
        if (null !== $entity && null === $entity->getId()) {
            $this->addPersist($entity);
        }

        $this->em->flush();
    }
}