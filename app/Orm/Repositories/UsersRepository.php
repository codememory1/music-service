<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\UserEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\Database\QueryBuilder\Interfaces\QueryBuilderInterface;
use ReflectionException;

/**
 * Class UsersRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class UsersRepository extends AbstractEntityRepository
{

    /**
     * @param array $by
     *
     * @return bool|UserEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findOne(array $by): bool|UserEntity
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
     * @param array $by
     *
     * @return bool|UserEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findOneByOr(array $by): bool|UserEntity
    {

        $qb = $this->createQueryBuilder();
        $qb
            ->setParameters($by)
            ->select()
            ->from($this->getEntityData()->getTableName())
            ->where($qb->expression()->exprOr(...$this->getConditionsFromBy($qb, $by)));

        $result = $qb->generateQuery()->toEntity();

        return [] !== $result ? $result[0] : false;

    }

    /**
     * @return int
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     */
    public function getCountUsers(): int
    {

        $qb = $this->createQueryBuilder();

        $qb->customSelect()->columns(['count' => 'COUNT(*)'])->from('users');

        return $qb->generateQuery()->getResult()->toArray()[0]['count'];
    }

    /**
     * @param array  $data
     * @param string $byEmail
     *
     * @return void
     * @throws QueryNotGeneratedException
     * @throws NotSelectedStatementException
     */
    public function update(array $data, string $byEmail): void
    {

        $qb = $this->createQueryBuilder();
        $values = array_map(function (mixed $column) {
            return ':' . $column;
        }, array_flip($data));

        $qb
            ->setParameters($data)
            ->setParameter('where_email', $byEmail)
            ->update($this->getEntityData()->getTableName())
            ->setData(array_keys($data), $values)
            ->where(
                $qb->expression()->exprAnd(
                    $qb->expression()->condition('email', '=', ':where_email')
                )
            );

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

}