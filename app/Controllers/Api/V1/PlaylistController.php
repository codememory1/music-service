<?php

namespace App\Controllers\Api\V1;

use App\Orm\Entities\PlaylistEntity;
use App\Orm\Repositories\PlaylistRepository;
use App\Services\Playlist\PlaylistCreatorService;
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
        $playlistRepository = $this->getDatabase()->getEntityManager()->getRepository(PlaylistEntity::class);
        $this->playlistRepository = $playlistRepository;

    }

    /**
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function all(): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            /** @var PlaylistRepository $playlistRepository */
            $playlistRepository = $this->getDatabase()->getEntityManager()->getRepository(PlaylistEntity::class);

            $this->response->json($playlistRepository->findAllAsArray([
                'userid' => $authorizedUser->getUserid()
            ]));
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
                'userid' => $authorizedUser->getUserid(),
                'id'     => $id
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

            $playlistCreationResponse = $playlistCreatorService->create($this->validatorManager(), $this->getDatabase()->getEntityManager(), $authorizedUser);

            $this->response->json($playlistCreationResponse->getResponse(), $playlistCreationResponse->getStatus());
        }

    }

}