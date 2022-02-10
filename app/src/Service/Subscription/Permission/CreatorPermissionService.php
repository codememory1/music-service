<?php

namespace App\Service\Subscription\Permission;

use App\DTO\SubscriptionPermissionDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\CreatorCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreatorPermissionService
 *
 * @package App\Service\Subscription\Permission
 *
 * @author  Codememory
 */
class CreatorPermissionService extends CreatorCRUDService
{

    /**
     * @param SubscriptionPermissionDTO $subscriptionPermissionDTO
     * @param ValidatorInterface        $validator
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function create(SubscriptionPermissionDTO $subscriptionPermissionDTO, ValidatorInterface $validator): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;

        $createdEntity = $this->make($subscriptionPermissionDTO);

        if ($createdEntity instanceof ApiResponseService) {
            return $createdEntity;
        }

        return $this->push($createdEntity, 'subscriptionPermission@successCreate');

    }

}