<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\PlaylistEntity;
use Codememory\Components\Database\Orm\QueryBuilder\ExtendedQueryBuilder;
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

        $findOne = $this->findOneHandler($by)->toEntity();

        return [] !== $findOne ? $findOne[0] : false;

    }

    /**
     * @param array $by
     *
     * @return array
     * @throws NotSelectedStatementException
     */
    public function findAllAsArray(array $by = []): array
    {

        $qb = $this->createQueryBuilder();
        $statement = $qb
            ->select()
            ->from($this->getEntityData()->getTableName());

        if ([] !== $by) {
            $statement->where($qb->expression()->exprAnd(...$this->getConditionsFromBy($qb, $by)));
            $qb->setParameters($by);
        }

        return $qb->generateResult()->toArray();

    }

    /**
     * @param array $by
     *
     * @return array
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     */
    public function findOneAsArray(array $by): array
    {

        $findOne = $this->findOneHandler($by)->getResult()->toArray();

        return [] !== $findOne ? $findOne[0] : [];

    }

    /**
     * @param array $by
     *
     * @return void
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     */
    public function delete(array $by): void
    {

        $qb = $this->createQueryBuilder();
        $qb
            ->setParameters($by)
            ->delete($this->getEntityData()->getTableName())
            ->where($qb->expression()->exprAnd(...$this->getConditionsFromBy($qb, $by)));

        $qb->generateQuery()->execute();

    }

    /**
     * @param array $data
     * @param array $by
     *
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     */
    public function update(array $data, array $by): void
    {

        $qb = $this->createQueryBuilder();
        $columns = array_keys($data);
        $values = array_map(function (string $key) {
            return ':' . $key;
        }, $columns);

        $qb
            ->setParameters(array_merge($data, $by))
            ->update($this->getEntityData()->getTableName())
            ->setData($columns, $values)
            ->where($qb->expression()->exprAnd(...$this->getConditionsFromBy($qb, $by)));

        $qb->generateQuery()->execute();

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

    /**
     * @param array $by
     *
     * @return QueryBuilderInterface|ExtendedQueryBuilder
     * @throws NotSelectedStatementException
     */
    private function findOneHandler(array $by): QueryBuilderInterface|ExtendedQueryBuilder
    {

        $qb = $this->createQueryBuilder();
        $qb
            ->setParameters($by)
            ->select()
            ->from($this->getEntityData()->getTableName())
            ->where($qb->expression()->exprAnd(...$this->getConditionsFromBy($qb, $by)));

        return $qb->generateQuery();

    }

}