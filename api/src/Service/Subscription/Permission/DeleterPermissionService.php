<?php

namespace App\Service\Subscription\Permission;

use App\Entity\SubscriptionPermission;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterPermissionService.
 *
 * @package App\Service\Subscription\Permission
 *
 * @author  Codememory
 */
class DeleterPermissionService extends DeleterCRUD
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
        $this->translationKeyNotExist = 'subscriptionPermission@notExist';

        /** @var SubscriptionPermission|Response $deletedSubscriptionPermission */
        $deletedSubscriptionPermission = $this->make(SubscriptionPermission::class, ['id' => $id]);

        if ($deletedSubscriptionPermission instanceof Response) {
            return $deletedSubscriptionPermission;
        }

        return $this->manager->remove($deletedSubscriptionPermission, 'subscriptionPermission@successDelete');
    }
}