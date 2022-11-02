<?php

namespace App\Service\MultimediaCategory;

use App\Entity\MultimediaCategory;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteMultimediaCategoryService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

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