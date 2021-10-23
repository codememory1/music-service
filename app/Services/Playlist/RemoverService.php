<?php

namespace App\Services\Playlist;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\PlaylistRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class RemoverService
 *
 * @package App\Services\Playlist
 *
 * @author  Danil
 */
class RemoverService extends AbstractApiService
{

    /**
     * @param PlaylistRepository $playlistRepository
     * @param UserEntity         $userEntity
     * @param int                $id
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function delete(PlaylistRepository $playlistRepository, UserEntity $userEntity, int $id): ResponseApiCollectorService
    {

        $searchBy = [
            'user_id' => $userEntity->getId(),
            'id'      => $id
        ];
        $finedPlaylist = $playlistRepository->findOne($searchBy);

        // Checking the existence of a playlist for an authorized user
        if (false === $finedPlaylist) {
            return $this->createApiResponse(404, 'playlist.notExist');
        }

        // Playlist found. Delete from the database
        $playlistRepository->delete($searchBy);

        return $this->createApiResponse(200, 'playlist.successDelete');

    }

}