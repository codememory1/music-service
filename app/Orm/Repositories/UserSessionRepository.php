<?php

namespace App\Orm\Repositories;

use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class UserSessionRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class UserSessionRepository extends AbstractEntityRepository
{

    /**
     * @return void
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function deleteInvalidTokens(): void
    {

        $qb = $this->createQueryBuilder();

        $qb
            ->delete()
            ->from($this->getEntityData()->getTableName())
            ->where(
                $qb->expression()->exprAnd(
                    $qb->expression()->condition('valid_to', '<', 'NOW()')
                )
            )
            ->execute();

    }

}