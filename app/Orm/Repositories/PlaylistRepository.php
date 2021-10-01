<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\PlaylistEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\Database\QueryBuilder\Interfaces\QueryBuilderInterface;
use ReflectionException;

/**
 * Class PlaylistRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class PlaylistRepository extends AbstractEntityRepository
{

    /**
     * @param array $by
     *
     * @return bool|PlaylistEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findOne(array $by): bool|PlaylistEntity
    {

        $qb = $this->createQueryBuilder();
        $qb
            ->setParameters($by)
            ->select()
            ->from($this->getEntityData()->getTableName())
            ->where($qb->expression()->exprAnd(...$this->getConditionsFromBy($qb, $by)));

        $result = $qb->generateQuery()->toEntity();

        return [] !== $result ? $result[0] : false;

    }

    /**
     * @param QueryBuilderInterface $queryBuilder
     * @param array                 $by
     *
     * @return array
     */
    private function getConditionsFromBy(QueryBuilderInterface $queryBuilder, array $by): array
    {

        $conditions = [];

        foreach ($by as $column => $value) {
            $conditions[] = $queryBuilder->expression()->condition($column, '=', ':' . $column);
        }

        return $conditions;

    }

}