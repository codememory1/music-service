<?php

namespace App\Services\Playlist;

use App\Orm\Entities\PlaylistEntity;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\PlaylistRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Validations\Playlist\PlaylistCreationValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\DateTime;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class CreatorService
 *
 * @package App\Services\Playlist
 *
 * @author  Danil
 */
class CreatorService extends AbstractApiService
{

    /**
     * @param ValidationManager  $validationManager
     * @param UserEntity         $userEntity
     * @param PlaylistRepository $playlistRepository
     *
     * @return ResponseApiCollectorService
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function create(ValidationManager $validationManager, UserEntity $userEntity, PlaylistRepository $playlistRepository): ResponseApiCollectorService
    {

        $creationValidationManager = $this->inputValidation($validationManager);

        // Input validation
        if (!$creationValidationManager->isValidation()) {
            return $this->apiResponse->create(400, $creationValidationManager->getErrors());
        }

        // Check the existence of a playlist with an input title
        if (true !== $responseExistPlaylist = $this->existPlaylist($playlistRepository, $userEntity)) {
            return $responseExistPlaylist;
        }

        // A playlist is created, and we return a response about successful creation
        return $this->pushPlaylist($this->getCollectedPlaylistEntity($userEntity));

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new PlaylistCreationValidation(), $this->request->post()->all());

    }

    /**
     * @param PlaylistRepository $playlistRepository
     * @param UserEntity         $userEntity
     *
     * @return ResponseApiCollectorService|bool
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function existPlaylist(PlaylistRepository $playlistRepository, UserEntity $userEntity): ResponseApiCollectorService|bool
    {

        // Checking the existence of a playlist with an input name for an authorized user
        $finedPlaylist = $playlistRepository->findOne([
            'user_id' => $userEntity->getId(),
            'name'    => $this->request->post()->get('name')
        ]);

        if (false !== $finedPlaylist) {
            return $this->createApiResponse(400, 'playlist@exist');
        }

        return true;

    }

    /**
     * @param UserEntity $userEntity
     *
     * @return PlaylistEntity
     * @throws InvalidTimezoneException
     */
    private function getCollectedPlaylistEntity(UserEntity $userEntity): PlaylistEntity
    {

        $playlistEntity = new PlaylistEntity();
        $temporary = $this->request->post()->get('temporary');

        // Changing the date format
        if (!empty($temporary)) {
            $temporary = (new DateTime())->setDate($temporary)->format('Y-m-d H:i:s');
        }

        $playlistEntity
            ->setUserId($userEntity->getId())
            ->setName($this->request->post()->get('name'))
            ->setTemporary($temporary);

        return $playlistEntity;

    }

    /**
     * @param PlaylistEntity $playlistEntity
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function pushPlaylist(PlaylistEntity $playlistEntity): ResponseApiCollectorService
    {

        // Save the data of the generated playlist to the database
        $this->getEntityManager()->commit($playlistEntity)->flush();

        return $this->createApiResponse(201, 'playlist@successCreate');

    }

}