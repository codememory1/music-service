<?php

namespace App\Orm\Repositories;

use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class SubscriptionOptionNameRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class SubscriptionOptionNameRepository extends AbstractEntityRepository
{

    /**
     * @param array $by
     *
     * @return array
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findAllBy(array $by): array
    {

        return $this->findBy($by);

    }

}