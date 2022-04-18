<?php

namespace App\Service\SubscriptionPermissionName;

use App\Entity\SubscriptionPermissionName;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterPermissionNameService.
 *
 * @package App\Service\SubscriptionPermissionName
 *
 * @author  Codememory
 */
class DeleterPermissionNameService extends DeleterCRUD
{
    /**
     * @param int $id
     *
     * @throws Exception
     *
     * @return Response
     */
    public function delete(int $id): Response
    {
        $this->translationKeyNotExist = 'subscriptionPermissionName@notExist';

        /** @var Response|SubscriptionPermissionName $deletedSubscriptionPermissionName */
        $deletedSubscriptionPermissionName = $this->make(SubscriptionPermissionName::class, ['id' => $id]);

        if ($deletedSubscriptionPermissionName instanceof Response) {
            return $deletedSubscriptionPermissionName;
        }

        return $this->manager->remove(
            $deletedSubscriptionPermissionName,
            'subscriptionPermissionName@successDelete'
        );
    }
}