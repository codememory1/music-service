<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\PasswordResetEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class PasswordResetRepository
 *
 * @package App\Orm\Repositories
 */
class PasswordResetRepository extends AbstractEntityRepository
{

    /**
     * @param array $by
     *
     * @return bool|PasswordResetEntity
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findOne(array $by): bool|PasswordResetEntity
    {

        return $this->customFindBy($by)->entity()->first();

    }

}