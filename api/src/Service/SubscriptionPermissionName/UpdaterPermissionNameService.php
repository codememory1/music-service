<?php

namespace App\Service\SubscriptionPermissionName;

use App\DTO\SubscriptionPermissionNameDTO;
use App\Entity\SubscriptionPermissionName;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterPermissionNameService.
 *
 * @package App\Service\SubscriptionPermissionName
 *
 * @author  Codememory
 */
class UpdaterPermissionNameService extends UpdaterCRUD
{
    /**
     * @param SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO
     * @param int                           $id
     *
     * @return Response
     */
    public function update(SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO, int $id): Response
    {
        $this->validateEntity = true;
        $this->translationKeyNotExist = 'subscriptionPermissionName@notExist';

        /** @var Response|SubscriptionPermissionName $updatedSubscriptionPermissionName */
        $updatedSubscriptionPermissionName = $this->make($subscriptionPermissionNameDTO, ['id' => $id]);

        if ($updatedSubscriptionPermissionName instanceof Response) {
            return $updatedSubscriptionPermissionName;
        }

        return $this->manager->update(
            $updatedSubscriptionPermissionName,
            'subscriptionPermissionName@successUpdate'
        );
    }
}