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
    /**
     * @param TranslationDTO $translationDTO
     *
     * @return JsonResponse
     */
    public function make(TranslationDTO $translationDTO): JsonResponse
    {
        if (false === $this->validate($translationDTO)) {
            return $this->validator->getResponse();
        }

        $translationEntity = $translationDTO->getEntity();

        $translationEntity->setTranslationKey($this->createTranslationKey($translationDTO));

        $this->em->persist($translationEntity);
        $this->em->flush();

        return $this->responseCollection->successCreate('translation@successCreate');
    }

    /**
     * @param TranslationDTO $translationDTO
     *
     * @return TranslationKey
     */
    private function createTranslationKey(TranslationDTO $translationDTO): TranslationKey
    {
        $translationKeyEntity = new TranslationKey();

        $translationKeyEntity->setKey($translationDTO->translationKey);

        return $translationKeyEntity;
    }
}