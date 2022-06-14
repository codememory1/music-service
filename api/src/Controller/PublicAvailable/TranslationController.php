<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\EntityNotFound;
use App\Entity\Language;
use App\Repository\TranslationRepository;
use App\ResponseData\TranslationResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TranslationController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/translation')]
class TranslationController extends AbstractRestController
{
    /**
     * @param Language                $language
     * @param TranslationResponseData $translationResponseData
     * @param TranslationRepository   $translationRepository
     *
     * @return JsonResponse
     */
    #[Route('/{language_code<[a-z]{2,5}>}/all')]
    public function allByLanguageCode(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        TranslationResponseData $translationResponseData,
        TranslationRepository $translationRepository
    ): JsonResponse {
        $translationResponseData->setEntities($translationRepository->findByCriteria([
            'language' => $language
        ]));
        $translationResponseData->collect();

        return $this->responseCollection->dataOutput($translationResponseData->getResponse());
    }
}