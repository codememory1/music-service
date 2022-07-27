<?php

namespace App\Service\Translation;

use App\DTO\DeleteTranslationDTO;
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
    public function make(DeleteTranslationDTO $deleteTranslationDTO, Translation $translation): JsonResponse
    {
        $this->flusherService->addRemove($translation);

        if ($deleteTranslationDTO->deleteKey) {
            $this->flusherService->addRemove($translation->getTranslationKey());
        }

        $this->flusherService->save();

        return $this->responseCollection->successDelete('translation@successDelete');
    }
}