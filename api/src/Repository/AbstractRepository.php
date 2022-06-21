<?php

namespace App\Repository;

use App\Service\DataRepresentation\FilterService;
use App\Service\DataRepresentation\SortService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AbstractRepository.
 *
 * @package App\Repository
 * @template Entity as mixed
 *
 * @author  Codememory
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    public const ORDER_TYPES = [
        'ASC', 'DESC'
    ];

    /**
     * @var null|string
     */
    protected ?string $entity = null;

    /**
     * @var null|string
     */
    protected ?string $alias = null;

    /**
     * @var QueryBuilder
     */
    protected readonly QueryBuilder $qb;

    /**
     * @var FilterService
     */
    protected readonly FilterService $filterService;

    /**
     * @var SortService
     */
    protected readonly SortService $sortService;

    /**
     * @param ManagerRegistry $registry
     * @param FilterService   $filterService
     * @param SortService     $sortService
     */
    public function __construct(ManagerRegistry $registry, FilterService $filterService, SortService $sortService)
    {
        parent::__construct($registry, $this->entity);

        $this->filterService = $filterService;
        $this->sortService = $sortService;

        $this->qb = $this->createQueryBuilder($this->alias);
    }

    /**
     * @param string      $type
     * @param null|string $default
     *
     * @return null|string
     */
    protected function getOrderType(string $type, ?string $default = null): ?string
    {
        return false === in_array($type, self::ORDER_TYPES, true) ? $default : $type;
    }

    /**
     * @return QueryBuilder
     */
    protected function getQueryBuilder(): QueryBuilder
    {
        return $this->qb;
    }

    /**
     * @param array             $criteria
     * @param array             $orderBy
     * @param null|QueryBuilder $qb
     *
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
     * @param mixed    $id
     * @param null|int $lockMode
     * @param null|int $lockVersion
     *
     * @return null|Entity
     */
    public function find(mixed $id, mixed $lockMode = null, mixed $lockVersion = null): mixed
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    /**
     * @param array      $criteria
     * @param null|array $orderBy
     *
     * @return null|Entity
     */
    public function findOneBy(array $criteria, ?array $orderBy = null): ?object
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}