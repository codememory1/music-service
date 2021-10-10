<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\PlaylistEntity;
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
class PlaylistRepository extends AbstractRepositoryWithSorting
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
     * @param array  $by
     * @param array  $sortBy
     * @param string $sortingType
     *
     * @return array
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findAllAsArray(array $by = [], array $sortBy = [], string $sortingType = 'desc'): array
    {

        return $this->findByWithSorting($by, $sortBy, $sortingType)->toArray();

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