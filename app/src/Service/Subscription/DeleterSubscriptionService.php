<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Service\CRUD\DeleterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DeleterSubscriptionService
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class DeleterSubscriptionService extends DeleterCRUDService
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
        $this->messageNameNotExist = 'subscription_not_exist';
        $this->translationKeyNotExist = 'subscription@notExist';

        $deletedEntity = $this->make(Subscription::class, ['id' => $id]);

        if ($deletedEntity instanceof ApiResponseService) {
            return $deletedEntity;
        }

        return $this->remove($deletedEntity, 'subscription@successDelete');

    }

}