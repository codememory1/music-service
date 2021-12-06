<?php

namespace App\Services\Album;

use App\Orm\Entities\AlbumEntity;
use App\Orm\Repositories\AlbumRepository;
use App\Services\AbstractApiService;
use Codememory\Components\Database\Pack\DatabasePack;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use ReflectionException;

/**
 * Class AlbumService
 *
 * @package App\Services\Album
 *
 * @author  Danil
 */
class AlbumService extends AbstractApiService
{

    /**
     * @var AlbumRepository
     */
    private AlbumRepository $albumRepository;

    /**
     * @param ServiceProviderInterface $serviceProvider
     * @param DatabasePack             $databasePack
     */
    public function __construct(ServiceProviderInterface $serviceProvider, DatabasePack $databasePack)
    {

        parent::__construct($serviceProvider, $databasePack);

        /** @var AlbumRepository $albumRepository */
        $albumRepository = $this->getRepository(AlbumEntity::class);
        $this->albumRepository = $albumRepository;

    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws StatementNotSelectedException
     * @throws ReflectionException
     */
    public function exist(int $id): bool
    {

        return false !== $this->albumRepository->findById($id);

    }

}