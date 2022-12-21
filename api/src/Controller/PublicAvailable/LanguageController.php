<?php

namespace App\Controller\PublicAvailable;

use App\Repository\LanguageRepository;
use App\ResponseData\General\Language\LanguageResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/language')]
class LanguageController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    public function all(LanguageResponseData $responseData, LanguageRepository $languageRepository): HttpResponseCollectorInterface
    {
        return $this->responseData($responseData, $languageRepository->findAll());
    }
}