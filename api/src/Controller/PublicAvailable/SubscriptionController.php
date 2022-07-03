<?php

namespace App\Controller\PublicAvailable;

use App\Repository\SubscriptionRepository;
use App\ResponseData\SubscriptionResponseData;
use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubscriptionController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/subscription')]
class SubscriptionController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    public function all(SubscriptionResponseData $subscriptionResponseData, SubscriptionRepository $subscriptionRepository): JsonResponse
    {
        $subscriptionResponseData->setEntities($subscriptionRepository->findAll());
        $subscriptionResponseData->collect();

        return $this->responseCollection->dataOutput($subscriptionResponseData->getResponse());
    }
}