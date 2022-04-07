<?php

namespace App\Service\Subscription;

use App\DTO\SubscriptionDTO;
use App\Entity\Subscription;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorSubscriptionService.
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class CreatorSubscriptionService extends CreatorCRUD
{
    /**
     * @param SubscriptionDTO $subscriptionDTO
     *
     * @return Response
     */
    public function create(SubscriptionDTO $subscriptionDTO): Response
    {
        /** @var Subscription|Response $createdSubscription */
        $createdSubscription = $this->make($subscriptionDTO);

        if ($createdSubscription instanceof Response) {
            return $createdSubscription;
        }

        return $this->manager->push($createdSubscription, 'subscription@successCreate');
    }
}