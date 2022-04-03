<?php

namespace App\Service\Subscription\Permission\Name;

use App\DTO\SubscriptionPermissionNameDTO;
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

        $createdEntity = $this->make($subscriptionPermissionNameDTO);

        if ($createdEntity instanceof Response) {
            return $createdEntity;
        }

        return $this->manager->push($createdEntity, 'subscriptionPermissionName@successCreate');
    }
}