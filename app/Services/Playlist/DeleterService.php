<?php

namespace App\Services\Playlist;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\PlaylistRepository;
use App\Services\AbstractCrudService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class DeleterService
 *
 * @package App\Services\Playlist
 *
 * @author  Danil
 */
class DeleterService extends AbstractCrudService
{

    /**
     * @param UserEntity         $userEntity
     * @param PlaylistRepository $playlistRepository
     * @param int                $id
     *
     * @return DeleterService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(UserEntity $userEntity, PlaylistRepository $playlistRepository, int $id): static
    {

        $searchBy = [
            'id'      => $id,
            'user_id' => $userEntity->getId()
        ];

        // Checking the existence of a playlist for an authorized user
        if (!$playlistRepository->findOne($searchBy)) {
            return $this->setResponse(
                $this->createApiResponse(404, 'playlist@notExist')
            );
        }

        // Playlist found. Delete from the database
        $playlistRepository->delete($searchBy);

        $this->setResponse(
            $this->createApiResponse(200, 'playlist@successDelete')
        );

        return $this;

    }

}