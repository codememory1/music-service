<?php

namespace App\Orm\Repositories;

use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
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
     * @throws ReflectionException
     * @throws StatementNotSelectedException
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
            ->innerJoin(
                ['arn' => 'access_right_names'],
                $qb->joinComparison('arn.id', 'rr.access_right_id')
            )
            ->where(
                $qb->expression()->exprAnd(
                    $qb->expression()->condition('role_id', '=', $roleId)
                )
            );

        return $qb->generateTo()->entity()->all();

    }

}