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
    /**
     * @param DeleteTranslationDTO $deleteTranslationDTO
     * @param Translation          $translation
     *
     * @return JsonResponse
     */
    public function make(DeleteTranslationDTO $deleteTranslationDTO, Translation $translation): JsonResponse
    {
        $this->em->remove($translation);

        if ($deleteTranslationDTO->deleteKey) {
            $this->em->remove($translation->getTranslationKey());
        }

        $this->em->flush();

        return $this->responseCollection->successDelete('translation@successDelete');
    }
}