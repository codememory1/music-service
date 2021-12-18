<?php

namespace App\Orm\Repositories;

use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
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
     * @throws ReflectionException
     * @throws StatementNotSelectedException
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
            ->innerJoin(
                ['son' => 'subscription_option_names'],
                $qb->joinComparison('so.subscription_option_name_id', 'son.id')
            )
            ->where(
                $qb->expression()->exprAnd(
                    $qb->expression()->condition('so.subscription_id', '=', ':id')
                )
            );

        return $qb->generateTo()->entity()->all();

    }

    /**
     * @param array $by
     *
     * @return bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function exist(array $by): bool
    {

        return [] !== $this->findBy($by);

    }

}