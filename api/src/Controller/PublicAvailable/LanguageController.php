<?php

namespace App\Controller\PublicAvailable;

use App\Repository\LanguageRepository;
use App\ResponseData\LanguageResponseData;
use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/language')]
class LanguageController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    public function all(LanguageResponseData $responseData, LanguageRepository $languageRepository): JsonResponse
    {
        $responseData->setEntities($languageRepository->findAll());

        return $this->responseData($responseData);
    }
}