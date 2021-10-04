<?php

namespace App\Orm\Repositories;

use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use ReflectionException;

/**
 * Class SubscriptionOptionNameRepository
 *
 * @package App\Orm\Repositories
 */
class SubscriptionOptionNameRepository extends AbstractEntityRepository
{

    /**
     * @param array $by
     *
     * @return array
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findAllBy(array $by): array
    {

        return $this->findBy($by)->toEntity();

    }

}