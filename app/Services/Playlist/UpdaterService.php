<?php

namespace App\Services\Playlist;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\PlaylistRepository;
use App\Services\AbstractCrudService;
use App\Validations\Playlist\PlaylistUpdateValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\DateTime;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use ReflectionException;

/**
 * Class UpdaterService
 *
 * @package App\Services\Playlist
 *
 * @author  Danil
 */
class UpdaterService extends AbstractCrudService
{

    /**
     * @param Manager            $manager
     * @param UserEntity         $userEntity
     * @param PlaylistRepository $playlistRepository
     * @param int                $id
     *
     * @return UpdaterService
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(Manager $manager, UserEntity $userEntity, PlaylistRepository $playlistRepository, int $id): static
    {

        $validatedDataManager = $this->makeInputValidation($manager, new PlaylistUpdateValidation());

        // Input validation
        if (!$validatedDataManager->isValidation()) {
            return $this->setResponse(
                $this->apiResponse->create(400, $validatedDataManager->getErrors())
            );
        }

        // Check if a given playlist exists with an authorized user
        if (!$this->existPlaylist($playlistRepository, $userEntity, $id)) {
            return $this->setResponse(
                $this->createApiResponse(400, 'playlist@notExist')
            );
        }

        // Updating playlist data in the database
        return $this->push($playlistRepository, $id);

    }

    /**
     * @param PlaylistRepository $playlistRepository
     * @param UserEntity         $userEntity
     * @param int                $id
     *
     * @return bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function existPlaylist(PlaylistRepository $playlistRepository, UserEntity $userEntity, int $id): bool
    {

        return (bool) $playlistRepository->findOne([
            'user_id' => $userEntity->getId(),
            'id'      => $id
        ]);

    }

    /**
     * @param PlaylistRepository $playlistRepository
     * @param int                $id
     *
     * @return UpdaterService
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function push(PlaylistRepository $playlistRepository, int $id): static
    {

        $request = $this->request->post();
        $updateData = ['name' => $request->get('name', escapingHtml: true)];
        $temporary = $request->get('temporary');

        // Changing the date format
        if (!empty($temporary)) {
            $dateTime = new DateTime();

            $updateData['temporary'] = $dateTime
                ->setDate($temporary)
                ->format('Y-m-d H:i:s');
        }

        // Updating the database
        $playlistRepository->update($updateData, ['id' => $id]);

        $this->setResponse(
            $this->createApiResponse(200, 'playlist@successUpdate')
        );

        return $this;

    }

}