<?php

namespace App\Service\Translation;

use App\Dto\Transfer\DeleteTranslationDto;
use App\Entity\Translation;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteTranslationService.
 *
 * @package App\Service\Translation
 *
 * @author  Codememory
 */
class DeleteTranslationService extends AbstractService
{
    public function delete(DeleteTranslationDto $deleteTranslationDto, Translation $translation): Translation
    {
        $this->flusherService->addRemove($translation);

        if ($deleteTranslationDto->deleteKey) {
            $this->flusherService->addRemove($translation->getTranslationKey());
        }

        $this->flusherService->save();

        return $translation;
    }

    public function request(DeleteTranslationDto $deleteTranslationDto, Translation $translation): JsonResponse
    {
        $this->delete($deleteTranslationDto, $translation);

        return $this->responseCollection->successDelete('translation@successDelete');
    }
}