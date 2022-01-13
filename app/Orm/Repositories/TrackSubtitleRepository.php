<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\TrackSubtitleEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class TrackSubtitleRepository
 *
 * @package App\Orm\Repositories
 */
class TrackSubtitleRepository extends AbstractEntityRepository
{

    /**
     * @param int $id
     *
     * @return bool|TrackSubtitleEntity
     * @throws StatementNotSelectedException
     * @throws ReflectionException
     */
    public function findByIdAsEntity(int $id): bool|TrackSubtitleEntity
    {

        return $this->customFindById($id)->entity()->first();

    }

}