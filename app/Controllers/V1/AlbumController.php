<?php

namespace App\Controllers\V1;

use App\Orm\Entities\AlbumEntity;
use App\Orm\Repositories\AccessRightNameRepository;
use App\Orm\Repositories\AlbumRepository;
use App\Services\Album\CreatorService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
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
     * @var AlbumRepository
     */
    private AlbumRepository $albumRepository;

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

        /** @var AlbumRepository $albumRepository */
        $albumRepository = $this->em->getRepository(AlbumEntity::class);
        $this->albumRepository = $albumRepository;

    }

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

    #[NoReturn]
    public function delete(int $id): void
    {


    }

}