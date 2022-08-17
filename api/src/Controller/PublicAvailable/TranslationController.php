<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\EntityNotFound;
use App\Entity\Language;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\TranslationRepository;
use App\ResponseData\TranslationResponseData;
use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/translation')]
class TranslationController extends AbstractRestController
{
    #[Route('/{language_code<[a-z]{2,5}>}/all')]
    public function allByLanguageCode(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        TranslationResponseData $translationResponseData,
        TranslationRepository $translationRepository
    ): JsonResponse {
        $translationResponseData->setEntities($translationRepository->findAllByLanguage($language));

        return $this->responseCollection->dataOutput($translationResponseData->getResponse());
    }
}