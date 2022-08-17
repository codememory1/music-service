<?php

namespace App\Service\MultimediaCategory;

use App\Dto\Transfer\MultimediaCategoryDto;
use App\Entity\MultimediaCategory;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateMultimediaCategoryService extends AbstractService
{
    public function update(MultimediaCategoryDto $multimediaCategoryDto): MultimediaCategory
    {
        $this->validate($multimediaCategoryDto);

        $this->flusherService->save();

        return $multimediaCategoryDto->getEntity();
    }

    public function request(MultimediaCategoryDto $multimediaCategoryDto): JsonResponse
    {
        $this->update($multimediaCategoryDto);

        return $this->responseCollection->successUpdate('multimediaCategory@successUpdate');
    }
}