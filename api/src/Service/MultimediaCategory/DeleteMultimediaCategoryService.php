<?php

namespace App\Service\MultimediaCategory;

use App\Entity\MultimediaCategory;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteMultimediaCategoryService.
 *
 * @package App\Service\MultimediaCategory
 *
 * @author  Codememory
 */
class DeleteMultimediaCategoryService extends AbstractService
{
    public function make(MultimediaCategory $multimediaCategory): JsonResponse
    {
        $this->flusherService->save($multimediaCategory);

        return $this->responseCollection->successUpdate('multimediaCategory@successDelete');
    }
}