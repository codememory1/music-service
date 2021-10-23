<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\SortingEntity;
use Codememory\Components\Database\Orm\Interfaces\EntityDataInterface;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\Orm\QueryBuilder\Answer\ResultTo;
use Codememory\Components\Database\Orm\QueryBuilder\ExtendedQueryBuilder;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class AbstractRepositoryWithSorting
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
abstract class AbstractRepositoryWithSorting extends AbstractEntityRepository
{

    /**
     * @var SortingRepository
     */
    protected SortingRepository $sortingRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ExtendedQueryBuilder   $queryBuilder
     * @param EntityDataInterface    $entityData
     */
    public function __construct(EntityManagerInterface $entityManager, ExtendedQueryBuilder $queryBuilder, EntityDataInterface $entityData)
    {

        parent::__construct($entityManager, $queryBuilder, $entityData);

        /** @var SortingRepository $sortingRepository */
        $sortingRepository = $this->getRepository(SortingEntity::class);
        $this->sortingRepository = $sortingRepository;

    }

    /**
     * @param array  $by
     * @param array  $sortBy
     * @param string $sortingType
     *
     * @return ResultTo
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    protected function findByWithSorting(array $by = [], array $sortBy = [], string $sortingType = 'desc'): ResultTo
    {

        $qb = $this->customFindByWithoutGenerate($by);

        // Add sorting with query
        $this->sortingRepository->addSorting(
            $qb,
            $this->getEntityData()->getTableName(),
            $sortBy,
            $sortingType
        );

        return $qb->generateTo();

    }

}