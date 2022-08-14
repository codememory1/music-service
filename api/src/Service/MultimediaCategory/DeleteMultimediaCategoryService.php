<?php

namespace App\Service\MultimediaCategory;

use App\Entity\MultimediaCategory;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteMultimediaCategoryService extends AbstractService
{
    public function delete(MultimediaCategory $multimediaCategory): MultimediaCategory
    {
        $this->flusherService->remove($multimediaCategory);

        return $multimediaCategory;
    }

    public function request(MultimediaCategory $multimediaCategory): JsonResponse
    {
        $this->delete($multimediaCategory);

        return $this->responseCollection->successUpdate('multimediaCategory@successDelete');
    }
}