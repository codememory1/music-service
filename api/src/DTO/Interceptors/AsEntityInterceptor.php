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
    private EntityManagerInterface $em;
    private string $entity;
    private string $by;
    private array $supplementBy;

    public function __construct(EntityManagerInterface $manager, string $entity, string $by = 'id', array $supplementBy = [])
    {
        $this->em = $manager;
        $this->entity = $entity;
        $this->by = $by;
        $this->supplementBy = $supplementBy;
    }

    public function handle(string $key, mixed $value): ?EntityInterface
    {
        $entityRepository = $this->em->getRepository($this->entity);

        return $entityRepository->findOneBy([$this->by => $value, ...$this->supplementBy]);
    }
}