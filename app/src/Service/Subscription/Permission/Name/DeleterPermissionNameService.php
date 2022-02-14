<?php

namespace App\Service\Subscription\Permission\Name;

use App\Entity\SubscriptionPermissionName;
use App\Service\CRUD\DeleterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @param ValidatorInterface $validator
     * @param int                $id
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function delete(ValidatorInterface $validator, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->messageNameNotExist = 'subscription_permission_name_not_exist';
        $this->translationKeyNotExist = 'subscriptionPermissionName@notExist';

        $deletedEntity = $this->make(SubscriptionPermissionName::class, ['id' => $id]);

        if ($deletedEntity instanceof ApiResponseService) {
            return $deletedEntity;
        }

        return $this->remove($deletedEntity, 'subscriptionPermissionName@successDelete');

    }

}