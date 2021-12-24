<?php

namespace App\Controllers\V1;

use App\Orm\Entities\PlaylistEntity;
use App\Orm\Repositories\PlaylistRepository;
use App\Services\Playlist\CreatorService;
use App\Services\Playlist\DeleterService;
use App\Services\Playlist\UpdaterService;
use App\Services\Sorting\DataService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use ErrorException;
use ReflectionException;

/**
 * Class PlaylistController
 *
 * @package App\Controllers\Api\V1
 *
 * @author  Danil
 */
class PlaylistController extends AbstractAuthorizationController
{

    /**
     * @var PlaylistRepository
     */
    private PlaylistRepository $playlistRepository;

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws BuilderNotCurrentSectionException
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var PlaylistRepository $playlistRepository */
        $playlistRepository = $this->em->getRepository(PlaylistEntity::class);
        $this->playlistRepository = $playlistRepository;

    }

    /**
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function all(): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            /** @var DataService $sortingDataService */
            $sortingDataService = $this->getService('Sorting\Data');

            // We get all the user's playlists and pass the data for sorting
            $playlists = $this->playlistRepository->findAllAsArray(
                ['user_id' => $authorizedUser->getId()],
                $sortingDataService->getColumns(),
                $sortingDataService->getType()
            );

            $this->response->json($playlists);
        }

    }

    /**
     * @param int $id
     *
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function show(int $id): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $playlist = $this->playlistRepository->findOneAsArray([
                'user_id' => $authorizedUser->getId(),
                'id'      => $id
            ]);

            if ([] == $playlist) {
                $this->responseWithTranslation(404, 'playlist@notExist');
            }

            $this->response->json($playlist);
        }

    }

    /**
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     * @throws ErrorException
     */
    public function create(): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            /** @var CreatorService $playlistCreatorService */
            $playlistCreatorService = $this->getService('Playlist\Creator');

            // Calling the playlist creation method from the service
            $createResponse = $playlistCreatorService
                ->make($this->validatorManager(), $authorizedUser)
                ->getResponseApiCollector();

            $this->response->json($createResponse->getResponse(), $createResponse->getStatus());
        }

    }

    /**
     * @param int $id
     *
     * @throws ErrorException
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function update(int $id): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            /** @var UpdaterService $playlistUpdaterService */
            $playlistUpdaterService = $this->getService('Playlist\Updater');

            // Calling the playlist update method
            $updateResponse = $playlistUpdaterService
                ->make($this->validatorManager(), $authorizedUser, $this->playlistRepository, $id)
                ->getResponseApiCollector();

            $this->response->json($updateResponse->getResponse(), $updateResponse->getStatus());
        }

    }

    /**
     * @param int $id
     *
     * @throws ErrorException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function delete(int $id): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            /** @var DeleterService $playlistDeleterService */
            $playlistDeleterService = $this->getService('Playlist\Deleter');

            // We delete the playlist and get the answer
            $deleteResponse = $playlistDeleterService
                ->make($authorizedUser, $this->playlistRepository, $id)
                ->getResponseApiCollector();

            $this->response->json($deleteResponse->getResponse(), $deleteResponse->getStatus());
        }

    }

}