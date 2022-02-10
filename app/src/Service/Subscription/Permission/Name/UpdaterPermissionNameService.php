<?php

namespace App\Service\Subscription\Permission\Name;

use App\DTO\SubscriptionPermissionNameDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\UpdaterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterPermissionNameService
 *
 * @package App\Service\Subscription\Permission\Name
 *
 * @author  Codememory
 */
class UpdaterPermissionNameService extends UpdaterCRUDService
{

    /**
     * @param SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO
     * @param ValidatorInterface            $validator
     * @param int                           $id
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function update(SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO, ValidatorInterface $validator, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;
        $this->messageNameNotExist = 'subscription_permission_name_not_exist';
        $this->translationKeyNotExist = 'subscriptionPermissionName@notExist';

        $updatedEntity = $this->make($subscriptionPermissionNameDTO, ['id' => $id]);

        if ($updatedEntity instanceof ApiResponseService) {
            return $updatedEntity;
        }

        return $this->push($updatedEntity, 'subscriptionPermissionName@successUpdate', true);

    }

}