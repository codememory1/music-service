<?php

namespace App\Service\MultimediaCategory;

use App\DTO\MultimediaCategoryDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdateMultimediaCategoryService.
 *
 * @package App\Service\MultimediaCategory
 *
 * @author  Codememory
 */
class UpdateMultimediaCategoryService extends AbstractService
{
    public function make(MultimediaCategoryDTO $multimediaCategoryDTO): JsonResponse
    {
        if (false === $this->validate($multimediaCategoryDTO)) {
            return $this->validator->getResponse();
        }

        $this->flusherService->save();

        return $this->responseCollection->successUpdate('multimediaCategory@successUpdate');
    }
}