<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\AlbumArtistEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class AlbumArtistRepository
 *
 * @package App\Orm\Repositories
 */
class AlbumArtistRepository extends AbstractEntityRepository
{

    /**
     * @param int $albumId
     * @param int $userId
     *
     * @return AlbumArtistEntity|bool
     * @throws StatementNotSelectedException
     * @throws ReflectionException
     */
    public function findAsEntity(int $albumId, int $userId): AlbumArtistEntity|bool
    {

        return $this->customFindBy([
            'album_id' => $albumId,
            'user_id' => $userId
        ])->entity()->first();

    }

}