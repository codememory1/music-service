<?php

namespace App\Controllers\V1;

use App\Orm\Repositories\AccessRightNameRepository;
use App\Services\Album\CreatorService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;
use ReflectionException;

/**
 * Class AlbumController
 *
 * @package App\Controllers\V1
 *
 * @author  Danil
 */
class AlbumController extends AbstractAuthorizationController
{

    /**
     * @return void
     * @throws StatementNotSelectedException
     * @throws ServiceNotExistException
     * @throws ErrorException
     * @throws ReflectionException
     */
    #[NoReturn]
    public function create(): void
    {

        $authorizedUser = $this->checkAuthWithRight(AccessRightNameRepository::ADD_MUSIC);

        /** @var CreatorService $albumCreatorService */
        $albumCreatorService = $this->getService('Album\Creator');

        // Album creation response
        $createResponse = $albumCreatorService
            ->make($this->validatorManager(), $authorizedUser)
            ->getResponseApiCollector();

        $this->response->json($createResponse->getResponse(), $createResponse->getStatus());

    }

}