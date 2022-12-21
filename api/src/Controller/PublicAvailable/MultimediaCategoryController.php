<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Repository\MultimediaCategoryRepository;
use App\ResponseData\General\Multimedia\MultimediaCategoryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/multimedia/category')]
#[Authorization]
class MultimediaCategoryController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    public function all(MultimediaCategoryResponseData $responseData, MultimediaCategoryRepository $multimediaCategoryRepository): HttpResponseCollectorInterface
    {
        return $this->responseData($responseData, $multimediaCategoryRepository->findAll());
    }
}