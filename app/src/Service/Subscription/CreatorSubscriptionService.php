<?php

namespace App\Service\Subscription;

use App\DTO\SubscriptionDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\CreatorCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreatorSubscriptionService
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class CreatorSubscriptionService extends CreatorCRUDService
{

    /**
     * @param SubscriptionDTO    $subscriptionDTO
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function create(SubscriptionDTO $subscriptionDTO, ValidatorInterface $validator): ApiResponseService
    {

        $this->validator = $validator;

        $createdEntity = $this->make($subscriptionDTO);

        if ($createdEntity instanceof ApiResponseService) {
            return $createdEntity;
        }

        return $this->push($createdEntity, 'subscription@successCreate');

    }

}