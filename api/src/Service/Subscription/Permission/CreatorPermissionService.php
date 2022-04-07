<?php

namespace App\Service\Subscription\Permission;

use App\DTO\SubscriptionPermissionDTO;
use App\Entity\SubscriptionPermission;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorPermissionService.
 *
 * @package App\Service\Subscription\Permission
 *
 * @author  Codememory
 */
class CreatorPermissionService extends CreatorCRUD
{
    /**
     * @param SubscriptionPermissionDTO $subscriptionPermissionDTO
     *
     * @return Response
     */
    public function create(SubscriptionPermissionDTO $subscriptionPermissionDTO): Response
    {
        $this->validateEntity = true;

        /** @var SubscriptionPermission|Response $createdSubscriptionPermission */
        $createdSubscriptionPermission = $this->make($subscriptionPermissionDTO);

        if ($createdSubscriptionPermission instanceof Response) {
            return $createdSubscriptionPermission;
        }

        return $this->manager->push($createdSubscriptionPermission, 'subscriptionPermission@successCreate');
    }
}