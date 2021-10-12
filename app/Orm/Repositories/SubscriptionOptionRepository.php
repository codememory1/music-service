<?php

namespace App\Orm\Repositories;

use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use ReflectionException;

/**
 * Class SubscriptionOptionRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class SubscriptionOptionRepository extends AbstractEntityRepository
{

    /**
     * @param int $id
     *
     * @return array
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findBySubscriptionWithName(int $id): array
    {

        $qb = $this->createQueryBuilder();
        $qb
            ->setParameter('id', $id)
            ->select([
                'so.*',
                'option_name'  => 'son.name',
                'option_title' => 'son.title'
            ])
            ->from($this->getEntityData()->getTableName(), 'so')
            ->join($qb->innerJoin(
                ['son' => 'subscription_option_names'],
                $qb->joinComparison('so.option_name_id', 'son.id')
            ))
            ->where(
                $qb->expression()->exprAnd(
                    $qb->expression()->condition('so.subscription', '=', ':id')
                )
            );

        return $qb->generateQuery()->toEntity();

    }

    /**
     * @param array $by
     *
     * @return bool
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function exist(array $by): bool
    {

        $result = $this->findBy($by)->toEntity();

        return [] !== $result;

    }

}