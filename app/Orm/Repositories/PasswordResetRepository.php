<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\PasswordResetEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
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
     * @throws NotSelectedStatementException
     * @throws ReflectionException
     * @throws QueryNotGeneratedException
     */
    public function findOne(array $by): bool|PasswordResetEntity
    {

        $result = $this->findBy($by)->toEntity();

        return $result[0] ?? false;

    }

}