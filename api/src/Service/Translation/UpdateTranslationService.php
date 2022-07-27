<?php

namespace App\Service\Translation;

use App\DTO\TranslationDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdateTranslationService.
 *
 * @package App\Service\Translation
 *
 * @author  Codememory
 */
class UpdateTranslationService extends AbstractService
{
    public function make(TranslationDTO $translationDTO): JsonResponse
    {
        if (false === $this->validate($translationDTO)) {
            return $this->validator->getResponse();
        }

        $translation = $translationDTO->getEntity();

        $translation->getTranslationKey()->setKey($translationDTO->translationKey);

        $this->flusherService->save();

        return $this->responseCollection->successCreate('translation@successUpdate');
    }
}