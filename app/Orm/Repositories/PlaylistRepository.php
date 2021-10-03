<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\PlaylistEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use ReflectionException;

/**
 * Class PlaylistRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class PlaylistRepository extends AbstractEntityRepository
{

    /**
     * @param array $by
     *
     * @return bool|PlaylistEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findOne(array $by): bool|PlaylistEntity
    {

        $findOne = $this->findBy($by)->toEntity();

        return [] !== $findOne ? $findOne[0] : false;

    }

    /**
     * @param array $by
     *
     * @return array
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findAllAsArray(array $by = []): array
    {

        return $this->findBy($by)->getResult()->toArray();

    }

    /**
     * @param array $by
     *
     * @return array
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findOneAsArray(array $by): array
    {

        $findOne = $this->findAllAsArray($by);

        return [] !== $findOne ? $findOne[0] : [];

    }

}