<?php

namespace App\Service\Subscription\Permission;

use App\DTO\SubscriptionPermissionDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\UpdaterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterPermissionService
 *
 * @package App\Service\Subscription\Permission
 *
 * @author  Codememory
 */
class UpdaterPermissionService extends UpdaterCRUDService
{

    /**
     * @param SubscriptionPermissionDTO $subscriptionPermissionDTO
     * @param ValidatorInterface        $validator
     * @param int                       $id
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function update(SubscriptionPermissionDTO $subscriptionPermissionDTO, ValidatorInterface $validator, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;
        $this->messageNameNotExist = 'subscription_not_exist';
        $this->translationKeyNotExist = 'subscriptionPermission@notExist';

        $updatedEntity = $this->make($subscriptionPermissionDTO, ['id' => $id]);

        if ($updatedEntity instanceof ApiResponseService) {
            return $updatedEntity;
        }

        return $this->push($updatedEntity, 'subscriptionPermission@successUpdate', true);

    }

}