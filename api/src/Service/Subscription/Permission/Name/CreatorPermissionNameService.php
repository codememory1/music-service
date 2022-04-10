<?php

namespace App\Service\Subscription\Permission\Name;

use App\DTO\SubscriptionPermissionNameDTO;
use App\Entity\SubscriptionPermissionName;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorPermissionNameService.
 *
 * @package App\Service\Subscription\Permission\Name
 *
 * @author  Codememory
 */
class CreatorPermissionNameService extends CreatorCRUD
{
    /**
     * @param SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO
     *
     * @return Response
     */
    public function create(SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO): Response
    {
        $this->validateEntity = true;

        /** @var Response|SubscriptionPermissionName $createdSubscriptionPermissionName */
        $createdSubscriptionPermissionName = $this->make($subscriptionPermissionNameDTO);

        if ($createdSubscriptionPermissionName instanceof Response) {
            return $createdSubscriptionPermissionName;
        }

        return $this->manager->push(
            $createdSubscriptionPermissionName,
            'subscriptionPermissionName@successCreate'
        );
    }
}