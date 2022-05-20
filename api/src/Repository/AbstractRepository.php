<?php

namespace App\Repository;

use App\Service\DataRepresentation\FilterService;
use App\Service\DataRepresentation\SortService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    /**
     * @var null|string
     */
    protected ?string $entity = null;

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
    }

    /**
     * @return array<Entity>
     */
    public function findAll(): array
    {
        return $this->findByCriteria([]);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     *
     * @return array<Entity>
     */
    public function findByCriteria(array $criteria, array $orderBy = []): array
    {
        $tableName = $this->getClassMetadata()->getTableName();
        $qb = $this->createQueryBuilder($tableName);

        foreach ($orderBy as $propertyName => $as) {
            $qb->orderBy("${tableName}.${propertyName}", $as);
        }

        foreach ($criteria as $propertyName => $value) {
            $qb
                ->andWhere("${tableName}.${propertyName} = :${propertyName}")
                ->setParameter($propertyName, $value);
        }

        return $qb->getQuery()->getResult() ?: [];
    }

    /**
     * @param mixed    $id
     * @param null|int $lockMode
     * @param null|int $lockVersion
     *
     * @return null|Entity
     */
    public function find(mixed $id, ?int $lockMode = null, ?int $lockVersion = null): ?object
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