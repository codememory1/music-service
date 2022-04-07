<?php

namespace App\Service\Subscription\Permission;

use App\DTO\SubscriptionPermissionDTO;
use App\Entity\SubscriptionPermission;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterPermissionService.
 *
 * @package App\Service\Subscription\Permission
 *
 * @author  Codememory
 */
class UpdaterPermissionService extends UpdaterCRUD
{
    /**
     * @param SubscriptionPermissionDTO $subscriptionPermissionDTO
     * @param int                       $id
     *
     * @return Response
     */
    public function update(SubscriptionPermissionDTO $subscriptionPermissionDTO, int $id): Response
    {
        $this->validateEntity = true;
        $this->translationKeyNotExist = 'subscriptionPermission@notExist';

        /** @var SubscriptionPermission|Response $updatedSubscriptionPermission */
        $updatedSubscriptionPermission = $this->make($subscriptionPermissionDTO, ['id' => $id]);

        if ($updatedSubscriptionPermission instanceof Response) {
            return $updatedSubscriptionPermission;
        }

        return $this->manager->update($updatedSubscriptionPermission, 'subscriptionPermission@successUpdate');
    }
}