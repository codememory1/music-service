<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\PlaylistEntity;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
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
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findOne(array $by): bool|PlaylistEntity
    {

        return $this->customFindBy($by)->entity()->first();

    }

    /**
     * @param array  $by
     * @param array  $sortBy
     * @param string $sortingType
     *
     * @return array
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findAllAsArray(array $by = [], array $sortBy = [], string $sortingType = 'desc'): array
    {

        return $this->findByWithSorting($by, $sortBy, $sortingType)->array()->all();

    }

    /**
     * @param array $by
     *
     * @return array
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findOneAsArray(array $by): array
    {

        $findOne = $this->findAllAsArray($by);

        return [] !== $findOne ? $findOne[0] : [];

    }

}