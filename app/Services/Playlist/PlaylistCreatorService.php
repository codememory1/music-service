<?php

namespace App\Services\Playlist;

use App\Orm\Entities\PlaylistEntity;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\PlaylistRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Validations\PlaylistCreationValidation;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\DateTime\DateTime;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class PlaylistCreatorService
 *
 * @package App\Services\Playlist
 *
 * @author  Danil
 */
class PlaylistCreatorService extends AbstractApiService
{

    /**
     * @param ValidationManager      $validationManager
     * @param EntityManagerInterface $entityManager
     * @param UserEntity             $userEntity
     *
     * @return ResponseApiCollectorService
     * @throws InvalidTimezoneException
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function create(ValidationManager $validationManager, EntityManagerInterface $entityManager, UserEntity $userEntity): ResponseApiCollectorService
    {

        $creationValidationManager = $this->inputValidation($validationManager);

        // Input validation
        if (!$creationValidationManager->isValidation()) {
            return $this->apiResponse->create(400, $creationValidationManager->getErrors());
        }

        // Check the existence of a playlist with an input title
        if (true !== $responseExistPlaylist = $this->existPlaylist($entityManager, $userEntity)) {
            return $responseExistPlaylist;
        }

        // A playlist is created, and we return a response about successful creation
        return $this->pushPlaylist($entityManager, $this->getCollectedPlaylistEntity($userEntity));

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
     * @param EntityManagerInterface $entityManager
     * @param UserEntity             $userEntity
     *
     * @return ResponseApiCollectorService|bool
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    private function existPlaylist(EntityManagerInterface $entityManager, UserEntity $userEntity): ResponseApiCollectorService|bool
    {

        /** @var PlaylistRepository $playlistRepository */
        $playlistRepository = $entityManager->getRepository(PlaylistEntity::class);

        // Checking the existence of a playlist with an input name for an authorized user
        $finedPlaylist = $playlistRepository->findOne([
            'user_id' => $userEntity->getId(),
            'name'    => $this->request->post()->get('name')
        ]);

        if (false !== $finedPlaylist) {
            return $this->createApiResponse(400, 'playlist.exist');
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
     * @param EntityManagerInterface $entityManager
     * @param PlaylistEntity         $playlistEntity
     *
     * @return ResponseApiCollectorService
     */
    private function pushPlaylist(EntityManagerInterface $entityManager, PlaylistEntity $playlistEntity): ResponseApiCollectorService
    {

        // Save the data of the generated playlist to the database
        $entityManager->commit($playlistEntity)->flush();

        return $this->createApiResponse(201, 'playlist.successCreated');

    }

}