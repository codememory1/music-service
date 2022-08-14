<?php

namespace App\Service\MultimediaCategory;

use App\Dto\Transfer\MultimediaCategoryDto;
use App\Entity\MultimediaCategory;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateMultimediaCategoryService extends AbstractService
{
    public function create(MultimediaCategoryDto $multimediaCategoryDto): MultimediaCategory
    {
        $this->validate($multimediaCategoryDto);

        $multimediaCategory = $multimediaCategoryDto->getEntity();

        $this->flusherService->save($multimediaCategory);

        return $multimediaCategory;
    }

    public function request(MultimediaCategoryDto $multimediaCategoryDto): JsonResponse
    {
        $this->create($multimediaCategoryDto);

        return $this->responseCollection->successCreate('multimediaCategory@successCreate');
    }
}