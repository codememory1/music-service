<?php

namespace App\Service\Subscription;

use App\DTO\SubscriptionDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\UpdaterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterSubscriptionService
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class UpdaterSubscriptionService extends UpdaterCRUDService
{

    /**
     * @param SubscriptionDTO    $subscriptionDTO
     * @param ValidatorInterface $validator
     * @param int                $id
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function update(SubscriptionDTO $subscriptionDTO, ValidatorInterface $validator, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->messageNameNotExist = 'subscription_not_exist';
        $this->translationKeyNotExist = 'subscription@notExist';

        $updatedEntity = $this->make($subscriptionDTO, ['id' => $id]);

        if ($updatedEntity instanceof ApiResponseService) {
            return $updatedEntity;
        }

        return $this->push($updatedEntity, 'subscription@successUpdate', true);

    }

}