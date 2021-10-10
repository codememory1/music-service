<?php

namespace App\Controllers\Api\V1;

use App\Orm\Entities\PlaylistEntity;
use App\Orm\Repositories\PlaylistRepository;
use App\Services\Playlist\PlaylistCreatorService;
use App\Services\Playlist\PlaylistRemoverService;
use App\Services\Playlist\PlaylistUpdaterService;
use App\Services\Sorting\DataService;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
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
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function all(): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            /** @var DataService $sortingDataService */
            $sortingDataService = $this->getService('Sorting\Data');
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
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function show(int $id): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->response->json($this->playlistRepository->findOneAsArray([
                'user_id' => $authorizedUser->getId(),
                'id'      => $id
            ]));
        }

    }

    /**
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws InvalidTimezoneException
     */
    public function create(): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            /** @var PlaylistCreatorService $playlistCreatorService */
            $playlistCreatorService = $this->getService('Playlist\PlaylistCreator');

            // Calling the playlist creation method from the service
            $playlistCreationResponse = $playlistCreatorService->create($this->validatorManager(), $this->em, $authorizedUser);

            $this->response->json($playlistCreationResponse->getResponse(), $playlistCreationResponse->getStatus());
        }

    }

    /**
     * @param int $id
     *
     * @throws InvalidTimezoneException
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function update(int $id): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            /** @var PlaylistUpdaterService $playlistUpdaterService */
            $playlistUpdaterService = $this->getService('Playlist\PlaylistUpdater');

            // Calling the playlist update method
            $playlistUpdateResponse = $playlistUpdaterService->update(
                $this->validatorManager(),
                $this->playlistRepository,
                $authorizedUser,
                $id
            );

            $this->response->json($playlistUpdateResponse->getResponse(), $playlistUpdateResponse->getStatus());
        }

    }

    /**
     * @param int $id
     *
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function delete(int $id): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            /** @var PlaylistRemoverService $playlistRemover */
            $playlistRemover = $this->getService('Playlist\PlaylistRemover');

            // Delete playlist entry
            $playlistDeleteResponse = $playlistRemover->delete($this->playlistRepository, $authorizedUser, $id);

            $this->response->json($playlistDeleteResponse->getResponse(), $playlistDeleteResponse->getStatus());
        }

    }

}