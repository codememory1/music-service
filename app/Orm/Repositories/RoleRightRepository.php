<?php

namespace App\Orm\Repositories;

use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use ReflectionException;

/**
 * Class RoleRightRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class RoleRightRepository extends AbstractEntityRepository
{

    /**
     * @param int $roleId
     *
     * @return array
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findAllWithNames(int $roleId): array
    {

        $qb = $this->createQueryBuilder();

        $qb
            ->select([
                'rr.*',
                'right_name' => 'arn.name',
                'arn_id'     => 'arn.id'
            ])
            ->from($this->getEntityData()->getTableName(), 'rr')
            ->join(
                $qb->innerJoin(
                    ['arn' => 'access_right_names'],
                    $qb->joinComparison('arn.id', 'rr.access_right')
                )
            )
            ->where(
                $qb->expression()->exprAnd(
                    $qb->expression()->condition('role_id', '=', $roleId)
                )
            );

        return $qb->generateQuery()->toEntity();

    }

}