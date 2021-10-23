<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\ActivationTokenEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
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
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findOne(array $by): bool|ActivationTokenEntity
    {

        return $this->customFindBy($by)->entity()->first();

    }

}