<?php

namespace App\Services\Playlist;

use App\Orm\Entities\PlaylistEntity;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\PlaylistRepository;
use App\Services\AbstractCrudService;
use App\Validations\Playlist\PlaylistCreationValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\DateTime;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use ReflectionException;

/**
 * Class CreatorService
 *
 * @package App\Services\Playlist
 *
 * @author  Danil
 */
class CreatorService extends AbstractCrudService
{

    /**
     * @param Manager    $manager
     * @param UserEntity $userEntity
     *
     * @return CreatorService
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(Manager $manager, UserEntity $userEntity): static
    {

        /** @var PlaylistRepository $playlistRepository */
        $playlistRepository = $this->getRepository(PlaylistEntity::class);
        $validatedDataManager = $this->makeInputValidation($manager, new PlaylistCreationValidation());

        // Input validation
        if (!$validatedDataManager->isValidation()) {
            return $this->setResponse(
                $this->apiResponse->create(400, $validatedDataManager->getErrors())
            );
        }

        // Check the existence of a playlist with an input title
        if (!$this->existPlaylist($playlistRepository, $userEntity)) {
            return $this->setResponse(
                $this->createApiResponse(400, 'playlist@exist')
            );
        }

        // Create a playlist and push it to the base
        return $this->push($userEntity);

    }

    /**
     * @param PlaylistRepository $playlistRepository
     * @param UserEntity         $userEntity
     *
     * @return bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function existPlaylist(PlaylistRepository $playlistRepository, UserEntity $userEntity): bool
    {

        return (bool) $playlistRepository->findOne([
            'user_id' => $userEntity->getId(),
            'name'    => $this->request->post()->get('name')
        ]);

    }

    /**
     * @param UserEntity $userEntity
     *
     * @return PlaylistEntity
     * @throws InvalidTimezoneException
     */
    private function getCollectedEntity(UserEntity $userEntity): PlaylistEntity
    {

        $playlistEntity = new PlaylistEntity();
        $temporary = $this->request->post()->get('temporary', escapingHtml: true);

        // Changing the date format
        if (!empty($temporary)) {
            $dateTime = new DateTime();
            $temporary = $dateTime
                ->setDate($temporary)
                ->format('Y-m-d H:i:s');
        }

        $playlistEntity
            ->setUserId($userEntity->getId())
            ->setName($this->request->post()->get('name', escapingHtml: true))
            ->setTemporary($temporary);

        return $playlistEntity;

    }

    /**
     * @param UserEntity $userEntity
     *
     * @return static
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function push(UserEntity $userEntity): static
    {

        // Save the data of the generated playlist to the database
        $this->getEntityManager()
            ->commit($this->getCollectedEntity($userEntity))
            ->flush();

        $this->setResponse(
            $this->createApiResponse(201, 'playlist@successCreate')
        );

        return $this;

    }

}