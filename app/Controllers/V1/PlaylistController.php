<?php

namespace App\Controllers\V1;

use App\Orm\Entities\PlaylistEntity;
use App\Orm\Repositories\PlaylistRepository;
use App\Services\Sorting\DataService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
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
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function create(): void
    {

        $this->initCrud('Playlist\Creator')
            ->addArgumentAuthUser()
            ->addArgument($this->validatorManager())
            ->checkIsAuth()
            ->response();

    }

    /**
     * @param int $id
     *
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function update(int $id): void
    {

        $this->initCrud('Playlist\Updater')
            ->addArgumentAuthUser()
            ->addArgument($this->validatorManager())
            ->addArgument($this->playlistRepository)
            ->addArgument($id)
            ->checkIsAuth()
            ->response();

    }

    /**
     * @param int $id
     *
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function delete(int $id): void
    {

        $this->initCrud('Playlist\Deleter')
            ->addArgumentAuthUser()
            ->addArgument($this->playlistRepository)
            ->addArgument($id)
            ->checkIsAuth()
            ->response();

    }

}