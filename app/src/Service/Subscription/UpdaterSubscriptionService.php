<?php

namespace App\Service\Subscription;

use App\DTO\SubscriptionDTO;
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

        $updatedEntity = $this->make($subscriptionDTO, ['id' => $id]);

        if ($updatedEntity instanceof Response) {
            return $updatedEntity;
        }

        return $this->manager->update($updatedEntity, 'subscription@successUpdate');
    }
}