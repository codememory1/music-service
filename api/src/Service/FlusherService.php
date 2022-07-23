<?php

namespace App\Service;

use App\Entity\Interfaces\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FlusherService.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class FlusherService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
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