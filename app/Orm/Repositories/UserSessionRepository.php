<?php

namespace App\Orm\Repositories;

use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
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
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function deleteInvalidTokens(): void
    {

        $qb = $this->createQueryBuilder();

        $qb
            ->delete($this->getEntityData()->getTableName())
            ->where(
                $qb->expression()->exprAnd(
                    $qb->expression()->condition('valid_to', '<', 'NOW()')
                )
            );

        $qb->generateQuery()->execute();

    }

}