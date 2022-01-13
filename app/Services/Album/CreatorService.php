<?php

namespace App\Services\Album;

use App\Orm\Entities\AlbumArtistEntity;
use App\Orm\Entities\AlbumEntity;
use App\Orm\Entities\AlbumTypeEntity;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\AlbumTypeRepository;
use App\Services\AbstractCrudService;
use App\Validations\Albums\CreationValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use ReflectionException;

/**
 * Class CreatorService
 *
 * @package App\Services\Album
 *
 * @author  Danil
 */
class CreatorService extends AbstractCrudService
{

    /**
     * @param Manager    $manager
     * @param UserEntity $userEntity
     *
     * @return $this
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     * @throws ServiceNotExistException
     */
    public function make(Manager $manager, UserEntity $userEntity): static
    {

        $validatedDataManager = $this->makeInputValidation($manager, new CreationValidation());

        // Input validation
        if (!$validatedDataManager->isValidation()) {
            return $this->setResponse(
                $this->apiResponse->create(400, $validatedDataManager->getErrors())
            );
        }

        // Check exist album type
        if (!$albumTypeEntity = $this->getTypeEntity($this->request->post()->get('type'))) {
            return $this->setResponse(
                $this->createApiResponse(404, 'album@typeNotExist')
            );
        }

        // We push the album and get the id of the created album,
        // and then we push the artist of the current album
        $this->pushAlbumArtist($userEntity, $this->pushAlbum($albumTypeEntity));

        return $this->setResponse(
            $this->createApiResponse(200, 'album@successCreate')
        );

    }

    /**
     * @param string $type
     *
     * @return AlbumTypeEntity|bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function getTypeEntity(string $type): AlbumTypeEntity|bool
    {

        /** @var AlbumTypeRepository $albumTypeRepository */
        $albumTypeRepository = $this->getRepository(AlbumTypeEntity::class);

        return $albumTypeRepository->customFindBy(['name' => $type])->entity()->first();

    }

    /**
     * @param AlbumTypeEntity $albumTypeEntity
     *
     * @return int
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function pushAlbum(AlbumTypeEntity $albumTypeEntity): int
    {

        $request = $this->request->post();
        $albumEntity = new AlbumEntity();

        $albumEntity
            ->setName($request->get('name'))
            ->setTypeId($albumTypeEntity->getId());

        $this->getEntityManager()->commit($albumEntity)->flush();

        return $this->getRepository(AlbumEntity::class)->getMaxId();

    }

    /**
     * @param UserEntity $userEntity
     * @param int        $albumId
     *
     * @return void
     */
    private function pushAlbumArtist(UserEntity $userEntity, int $albumId): void
    {

        $albumArtistEntity = new AlbumArtistEntity();

        $albumArtistEntity
            ->setAlbumId($albumId)
            ->setUserId($userEntity->getId());

        $this->getEntityManager()->commit($albumArtistEntity)->flush();

    }

}