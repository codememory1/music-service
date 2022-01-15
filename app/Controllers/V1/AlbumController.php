<?php

namespace App\Controllers\V1;

use App\Orm\Entities\AlbumEntity;
use App\Orm\Repositories\AccessRightNameRepository;
use App\Orm\Repositories\AlbumRepository;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
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
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function create(): void
    {

        $this->initCrud('Album\Creator')
            ->addArgumentAuthUser()
            ->addArgument($this->validatorManager())
            ->checkAccessRight(AccessRightNameRepository::ADD_MUSIC)
            ->response();

    }

    /**
     * @param int $id
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function delete(int $id): void
    {

        $this->initCrud('Album\Deleter')
            ->addArgumentAuthUser()
            ->addArgument($this->albumRepository)
            ->addArgument($id)
            ->checkAccessRight(AccessRightNameRepository::ADD_MUSIC)
            ->response();


    }

}