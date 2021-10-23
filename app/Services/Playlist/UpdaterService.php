<?php

namespace App\Services\Playlist;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\PlaylistRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Validations\Playlist\PlaylistUpdateValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\DateTime;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class UpdaterService
 *
 * @package App\Services\Playlist
 *
 * @author  Danil
 */
class UpdaterService extends AbstractApiService
{

    /**
     * @param ValidationManager  $validationManager
     * @param PlaylistRepository $playlistRepository
     * @param UserEntity         $userEntity
     * @param int                $id
     *
     * @return ResponseApiCollectorService
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function update(ValidationManager $validationManager, PlaylistRepository $playlistRepository, UserEntity $userEntity, int $id): ResponseApiCollectorService
    {

        // Check if a given playlist exists with an authorized user
        if (true !== $responseExistPlaylist = $this->existPlaylist($playlistRepository, $userEntity, $id)) {
            return $responseExistPlaylist;
        }

        $creationValidationManager = $this->inputValidation($validationManager);

        // Input validation
        if (!$creationValidationManager->isValidation()) {
            return $this->apiResponse->create(400, $creationValidationManager->getErrors());
        }

        // Updating playlist data in the database
        return $this->updatePlaylistData($playlistRepository, $id);

    }


    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new PlaylistUpdateValidation(), $this->request->post()->all());

    }

    /**
     * @param PlaylistRepository $playlistRepository
     * @param UserEntity         $userEntity
     * @param int                $id
     *
     * @return ResponseApiCollectorService|bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function existPlaylist(PlaylistRepository $playlistRepository, UserEntity $userEntity, int $id): ResponseApiCollectorService|bool
    {

        // Checking the existence of a playlist with an input name for an authorized user
        $finedPlaylist = $playlistRepository->findOne([
            'user_id' => $userEntity->getId(),
            'id'      => $id
        ]);

        if (false === $finedPlaylist) {
            return $this->createApiResponse(400, 'playlist.notExist');
        }

        return true;

    }

    /**
     * @param PlaylistRepository $playlistRepository
     * @param int                $id
     *
     * @return ResponseApiCollectorService
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function updatePlaylistData(PlaylistRepository $playlistRepository, int $id): ResponseApiCollectorService
    {

        $updateData = [
            'name' => $this->request->post()->get('name')
        ];

        // Changing the date format
        if (!empty($temporary)) {
            $updateData['temporary'] = (new DateTime())->setDate($temporary)->format('Y-m-d H:i:s');
        }

        // Updating the database
        $playlistRepository->update($updateData, ['id' => $id]);

        return $this->createApiResponse(200, 'playlist.successUpdate');

    }

}