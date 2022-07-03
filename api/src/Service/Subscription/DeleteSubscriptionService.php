<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteSubscriptionService.
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class DeleteSubscriptionService extends AbstractService
{
    public function make(Subscription $subscription): JsonResponse
    {
        $this->em->remove($subscription);
        $this->em->flush();

        return $this->responseCollection->successDelete('subscription@successDelete');
    }
}