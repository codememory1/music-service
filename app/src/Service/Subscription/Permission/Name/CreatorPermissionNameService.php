<?php

namespace App\Service\Subscription\Permission\Name;

use App\DTO\SubscriptionPermissionNameDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\CreatorCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreatorPermissionNameService
 *
 * @package App\Service\Subscription\Permission\Name
 *
 * @author  Codememory
 */
class CreatorPermissionNameService extends CreatorCRUDService
{

    /**
     * @param SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO
     * @param ValidatorInterface            $validator
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function create(SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO, ValidatorInterface $validator): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;

        $createdEntity = $this->make($subscriptionPermissionNameDTO);

        if ($createdEntity instanceof ApiResponseService) {
            return $createdEntity;
        }

        return $this->push($createdEntity, 'subscriptionPermissionName@successCreate');

    }

}