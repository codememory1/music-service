<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Repository\MultimediaCategoryRepository;
use App\ResponseData\MultimediaCategoryResponseData;
use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultimediaCategoryController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/multimedia/category')]
class MultimediaCategoryController extends AbstractRestController
{
    /**
     * @param MultimediaCategoryResponseData $multimediaCategoryResponseData
     * @param MultimediaCategoryRepository   $multimediaCategoryRepository
     *
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    #[Authorization]
    public function all(MultimediaCategoryResponseData $multimediaCategoryResponseData, MultimediaCategoryRepository $multimediaCategoryRepository): JsonResponse
    {
        $multimediaCategoryResponseData->setEntities($multimediaCategoryRepository->findAll());
        $multimediaCategoryResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaCategoryResponseData->getResponse());
    }
}