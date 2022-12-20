<?php

namespace App\Controller\PublicAvailable;

use App\Repository\SubscriptionRepository;
use App\ResponseData\General\Subscription\SubscriptionResponseData;
use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/subscription')]
class SubscriptionController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    public function all(SubscriptionResponseData $responseData, SubscriptionRepository $subscriptionRepository): JsonResponse
    {
        return $this->responseData($responseData, $subscriptionRepository->findAll());
    }
}