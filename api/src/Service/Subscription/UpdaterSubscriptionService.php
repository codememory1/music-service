<?php

namespace App\Service\Subscription;

use App\DTO\SubscriptionDTO;
use App\Entity\Subscription;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterSubscriptionService.
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class UpdaterSubscriptionService extends UpdaterCRUD
{
    /**
     * @param SubscriptionDTO $subscriptionDTO
     * @param int             $id
     *
     * @return Response
     */
    public function update(SubscriptionDTO $subscriptionDTO, int $id): Response
    {
        $this->translationKeyNotExist = 'subscription@notExist';

        /** @var Response|Subscription $updatedSubscription */
        $updatedSubscription = $this->make($subscriptionDTO, ['id' => $id]);

        if ($updatedSubscription instanceof Response) {
            return $updatedSubscription;
        }

        return $this->manager->update($updatedSubscription, 'subscription@successUpdate');
    }
}