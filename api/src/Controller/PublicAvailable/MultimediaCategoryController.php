<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Repository\MultimediaCategoryRepository;
use App\ResponseData\MultimediaCategoryResponseData;
use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/multimedia/category')]
#[Authorization]
class MultimediaCategoryController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    public function all(MultimediaCategoryResponseData $multimediaCategoryResponseData, MultimediaCategoryRepository $multimediaCategoryRepository): JsonResponse
    {
        $multimediaCategoryResponseData->setEntities($multimediaCategoryRepository->findAll());

        return $this->responseCollection->dataOutput($multimediaCategoryResponseData->getResponse());
    }
}