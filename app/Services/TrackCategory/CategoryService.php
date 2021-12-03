<?php

namespace App\Services\TrackCategory;

use App\Orm\Repositories\TrackCategoryRepository;
use App\Services\AbstractApiService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
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
     * @param TrackCategoryRepository $trackCategoryRepository
     * @param int                     $id
     *
     * @return bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    final public function exist(TrackCategoryRepository $trackCategoryRepository, int $id): bool
    {

        return false !== $trackCategoryRepository->findById($id);

    }

}