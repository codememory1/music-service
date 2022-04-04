<?php

namespace App\DTO\Interceptor;

use App\Entity\AlbumCategory;
use App\Repository\AlbumCategoryRepository;
use App\Rest\DTO\AbstractInterceptor;

/**
 * Class AlbumInputCategoryInterceptor.
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class AlbumInputCategoryInterceptor extends AbstractInterceptor
{
    /**
     * @inheritDoc
     */
    public function process(string $requestKey, mixed $requestValue): ?AlbumCategory
    {
        /** @var AlbumCategoryRepository $albumCategoryRepository */
        $albumCategoryRepository = $this->context->em->getRepository(AlbumCategory::class);

        return $albumCategoryRepository->find($requestValue);
    }
}