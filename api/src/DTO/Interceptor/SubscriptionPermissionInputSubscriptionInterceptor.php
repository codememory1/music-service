<?php

namespace App\DTO\Interceptor;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use App\Rest\DTO\AbstractInterceptor;

/**
 * Class SubscriptionPermissionInputSubscriptionInterceptor.
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class SubscriptionPermissionInputSubscriptionInterceptor extends AbstractInterceptor
{
    /**
     * @inheritDoc
     */
    public function process(string $requestKey, mixed $requestValue): ?Subscription
    {
        /** @var SubscriptionRepository $subscriptionRepository */
        $subscriptionRepository = $this->context->em->getRepository(Subscription::class);

        return $subscriptionRepository->find($requestValue);
    }
}