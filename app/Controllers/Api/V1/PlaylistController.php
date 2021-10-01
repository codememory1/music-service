<?php

namespace App\Controllers\Api\V1;

use App\Services\Playlist\PlaylistCreatorService;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
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