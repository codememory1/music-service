<?php

namespace App\Controller\PublicAvailable;

use App\Repository\LanguageRepository;
use App\ResponseData\LanguageResponseData;
use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LanguageController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/language')]
class LanguageController extends AbstractRestController
{
    /**
     * @param LanguageResponseData $languageResponseData
     * @param LanguageRepository   $languageRepository
     *
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    public function all(LanguageResponseData $languageResponseData, LanguageRepository $languageRepository): JsonResponse
    {
        $languageResponseData->setEntities($languageRepository->findAll());

        return $this->responseCollection->dataOutput($languageResponseData->collect()->getResponse());
    }
}