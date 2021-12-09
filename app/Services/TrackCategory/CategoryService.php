<?php

namespace App\Services\TrackCategory;

use App\Orm\Entities\TrackCategoryEntity;
use App\Orm\Repositories\TrackCategoryRepository;
use App\Services\AbstractApiService;
use Codememory\Components\Database\Pack\DatabasePack;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use ReflectionException;

/**
 * Class CategoryService
 *
 * @package App\Services\TrackCategory
 *
 * @author  Danil
 */
class CategoryService extends AbstractApiService
{

    /**
     * @var TrackCategoryRepository
     */
    private TrackCategoryRepository $trackCategoryRepository;

    /**
     * @param ServiceProviderInterface $serviceProvider
     * @param DatabasePack             $databasePack
     */
    public function __construct(ServiceProviderInterface $serviceProvider, DatabasePack $databasePack)
    {

        parent::__construct($serviceProvider, $databasePack);

        /** @var TrackCategoryRepository $trackCategoryRepository */
        $trackCategoryRepository = $this->getRepository(TrackCategoryEntity::class);
        $this->trackCategoryRepository = $trackCategoryRepository;

    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    final public function exist(int $id): bool
    {

        return false !== $this->trackCategoryRepository->findById($id);

    }

}