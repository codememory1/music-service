<?php

namespace App\Service\Translation;

use App\DTO\TranslationDTO;
use App\Entity\TranslationKey;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CreateTranslationService.
 *
 * @package App\Service\Translation
 *
 * @author  Codememory
 */
class CreateTranslationService extends AbstractService
{
    public function make(TranslationDTO $translationDTO): JsonResponse
    {
        if (false === $this->validate($translationDTO)) {
            return $this->validator->getResponse();
        }

        $translation = $translationDTO->getEntity();

        $translation->setTranslationKey($this->createTranslationKey($translationDTO));

        $this->flusherService->save($translation);

        return $this->responseCollection->successCreate('translation@successCreate');
    }

    private function createTranslationKey(TranslationDTO $translationDTO): TranslationKey
    {
        $translationKey = new TranslationKey();

        $translationKey->setKey($translationDTO->translationKey);

        return $translationKey;
    }
}