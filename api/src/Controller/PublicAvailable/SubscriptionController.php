<?php

namespace App\Controller\PublicAvailable;

use App\Repository\SubscriptionRepository;
use App\ResponseData\General\Subscription\SubscriptionResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/subscription')]
class SubscriptionController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    public function all(SubscriptionResponseData $responseData, SubscriptionRepository $subscriptionRepository): HttpResponseCollectorInterface
    {
        return $this->responseData($responseData, $subscriptionRepository->findAll());
    }
}