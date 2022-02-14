<?php

namespace App\Service\Subscription\Permission;

use App\Entity\SubscriptionPermission;
use App\Service\CRUD\DeleterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DeleterPermissionService
 *
 * @package App\Service\Subscription\Permission
 *
 * @author  Codememory
 */
class DeleterPermissionService extends DeleterCRUDService
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
        $this->messageNameNotExist = 'permission_not_exist';
        $this->translationKeyNotExist = 'subscriptionPermission@notExist';

        $deletedEntity = $this->make(SubscriptionPermission::class, ['id' => $id]);

        if ($deletedEntity instanceof ApiResponseService) {
            return $deletedEntity;
        }

        return $this->remove($deletedEntity, 'subscriptionPermission@successDelete');

    }

}