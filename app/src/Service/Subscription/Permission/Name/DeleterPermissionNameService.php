<?php

namespace App\Service\Subscription\Permission\Name;

use App\Entity\SubscriptionPermissionName;
use App\Service\CRUD\DeleterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class DeleterPermissionNameService
 *
 * @package App\Service\Subscription\Permission\Name
 *
 * @author  Codememory
 */
class DeleterPermissionNameService extends DeleterCRUDService
{

    /**
     * @param int $id
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function delete(int $id): ApiResponseService
    {

        $this->messageNameNotExist = 'subscription_permission_name_not_exist';
        $this->translationKeyNotExist = 'subscriptionPermissionName@notExist';

        $deletedEntity = $this->make(SubscriptionPermissionName::class, ['id' => $id]);

        if ($deletedEntity instanceof ApiResponseService) {
            return $deletedEntity;
        }

        return $this->remove($deletedEntity, 'subscriptionPermissionName@successDelete');

    }

}