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

        $translationEntity = $translationDTO->getEntity();

        $translationEntity->getTranslationKey()->setKey($translationDTO->translationKey);

        $this->em->flush();

        return $this->responseCollection->successCreate('translation@successUpdate');
    }
}