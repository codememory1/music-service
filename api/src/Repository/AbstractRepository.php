<?php

namespace App\Repository;

use App\Service\DataRepresentation\FilterService;
use App\Service\DataRepresentation\SortService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template Entity as mixed
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    public const ORDER_TYPES = [
        'ASC', 'DESC'
    ];
    protected ?string $entity = null;
    protected ?string $alias = null;
    protected readonly QueryBuilder $qb;
    protected readonly FilterService $filterService;
    protected readonly SortService $sortService;

    public function __construct(ManagerRegistry $registry, FilterService $filterService, SortService $sortService)
    {
        parent::__construct($registry, $this->entity);

        $this->filterService = $filterService;
        $this->sortService = $sortService;

        $this->qb = $this->createQueryBuilder($this->alias);
    }

    protected function getOrderType(string $type, ?string $default = null): ?string
    {
        return false === in_array($type, self::ORDER_TYPES, true) ? $default : $type;
    }

    protected function getQueryBuilder(): QueryBuilder
    {
        return $this->qb;
    }

    /**
     * @return array<Entity>
     */
    protected function findByCriteria(array $criteria, array $orderBy = []): array
    {
        $qb = $this->getQueryBuilder();

        foreach ($orderBy as $propertyName => $as) {
            $qb->orderBy($propertyName, $as);
        }

        foreach ($criteria as $propertyName => $value) {
            $parameterName = str_replace('.', '_', $propertyName);

            $qb->andWhere("${propertyName} = :${parameterName}");
            $qb->setParameter($parameterName, $value);
        }

        return $qb->getQuery()->getResult() ?: [];
    }

    /**
     * @return array<Entity>
     */
    public function findAll(): array
    {
        return $this->findByCriteria([]);
    }

    /**
     * @return null|Entity
     */
    public function find(mixed $id, mixed $lockMode = null, mixed $lockVersion = null): mixed
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    /**
     * @return null|Entity
     */
    public function findOneBy(array $criteria, ?array $orderBy = null): ?object
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}