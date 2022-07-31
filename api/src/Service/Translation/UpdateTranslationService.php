<?php

namespace App\Service\Translation;

use App\Dto\Transfer\TranslationDto;
use App\Entity\Translation;
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
    public function update(TranslationDto $translationDto): Translation
    {
        $this->validate($translationDto);

        $translation = $translationDto->getEntity();

        $translation->getTranslationKey()->setKey($translationDto->translationKey);

        $this->flusherService->save();

        return $translation;
    }

    public function request(TranslationDto $translationDto): JsonResponse
    {
        $this->update($translationDto);

        return $this->responseCollection->successCreate('translation@successUpdate');
    }
}