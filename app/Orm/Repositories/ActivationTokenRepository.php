<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\ActivationTokenEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use ReflectionException;

/**
 * Class ActivationTokenRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class ActivationTokenRepository extends AbstractEntityRepository
{

    /**
     * @param array $by
     *
     * @return bool|ActivationTokenEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findOne(array $by): bool|ActivationTokenEntity
    {

        $result = $this->findBy($by)->toEntity();

        return [] === $result ? false : $result[0];

    }

}