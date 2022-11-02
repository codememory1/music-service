<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteSubscriptionService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

    public function delete(Subscription $subscription): Subscription
    {
        $this->flusherService->remove($subscription);

        return $subscription;
    }

    public function request(Subscription $subscription): JsonResponse
    {
        $this->delete($subscription);

        return $this->responseCollection->successDelete('subscription@successDelete');
    }
}