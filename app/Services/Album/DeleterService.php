<?php

namespace App\Services\Album;

use App\Orm\Entities\AlbumArtistEntity;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\AlbumArtistRepository;
use App\Orm\Repositories\AlbumRepository;
use App\Services\AbstractCrudService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class DeleterService
 *
 * @package App\Services\Album
 *
 * @author  Danil
 */
class DeleterService extends AbstractCrudService
{

    /**
     * @param UserEntity      $userEntity
     * @param AlbumRepository $albumRepository
     * @param int             $id
     *
     * @return $this
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     * @throws ServiceNotExistException
     */
    public function make(UserEntity $userEntity, AlbumRepository $albumRepository, int $id): static
    {

        /** @var AlbumArtistRepository $albumArtistRepository */
        $albumArtistRepository = $this->getRepository(AlbumArtistEntity::class);

        $finedAlbumArtist = $albumArtistRepository->findAsEntity($id, $userEntity->getId());

        // Checking if an album exists
        if (!$finedAlbumArtist) {
            $this->setResponse(
                $this->createApiResponse(404, 'album@notExist')
            );
        }

        // Deleting an album
        $this->push($albumRepository, $albumArtistRepository, $finedAlbumArtist);

        return $this->setResponse(
            $this->createApiResponse(200, 'album@successDelete')
        );

    }

    /**
     * @param AlbumRepository       $albumRepository
     * @param AlbumArtistRepository $albumArtistRepository
     * @param AlbumArtistEntity     $albumArtistEntity
     *
     * @return void
     * @throws StatementNotSelectedException
     * @throws ReflectionException
     */
    private function push(AlbumRepository $albumRepository, AlbumArtistRepository $albumArtistRepository, AlbumArtistEntity $albumArtistEntity): void
    {

        $albumRepository->delete(['id' => $albumArtistEntity->getAlbumId()]);
        $albumArtistRepository->delete(['id' => $albumArtistEntity->getAlbumId()]);

    }

}