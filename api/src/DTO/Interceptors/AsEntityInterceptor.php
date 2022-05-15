<?php

namespace App\DTO\Interceptors;

use App\DTO\Interfaces\ValueInterceptorInterface;
use App\Entity\Interfaces\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AsEntityInterceptor.
 *
 * @package App\DTO\Interceptors
 *
 * @author  Codememory
 */
class AsEntityInterceptor implements ValueInterceptorInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var string
     */
    private string $entity;

    /**
     * @var string
     */
    private string $by;

    /**
     * @param EntityManagerInterface $manager
     * @param string                 $entity
     * @param string                 $by
     */
    public function __construct(EntityManagerInterface $manager, string $entity, string $by = 'id')
    {
        $this->em = $manager;
        $this->entity = $entity;
        $this->by = $by;
    }

    /**
     * @inheritDoc
     */
    public function handle(string $key, mixed $value): ?EntityInterface
    {
        $entityRepository = $this->em->getRepository($this->entity);

        return $entityRepository->findOneBy([$this->by => $value]);
    }
}