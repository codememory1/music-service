<?php

namespace App\Service\MultimediaCategory;

use App\DTO\MultimediaCategoryDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CreateMultimediaCategoryService.
 *
 * @package App\Service\MultimediaCategory
 *
 * @author  Codememory
 */
class CreateMultimediaCategoryService extends AbstractService
{
    public function make(MultimediaCategoryDTO $multimediaCategoryDTO): JsonResponse
    {
        if (false === $this->validate($multimediaCategoryDTO)) {
            return $this->validator->getResponse();
        }

        $this->flusherService->save($multimediaCategoryDTO->getEntity());

        return $this->responseCollection->successCreate('multimediaCategory@successCreate');
    }
}