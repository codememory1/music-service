<?php

namespace App\Service\Subscription\Permission\Name;

use App\Entity\SubscriptionPermissionName;
use App\Service\AbstractApiService;
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
class CreatorPermissionNameService extends AbstractApiService
{

    /**
     * @param ValidatorInterface $validator
     * @param callable           $handler
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function create(ValidatorInterface $validator, callable $handler): ApiResponseService
    {

        $collectedEntity = $this->collectEntity();

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Calling an Extender Method
        return call_user_func($handler, $collectedEntity);

    }

    /**
     * @return SubscriptionPermissionName
     */
    private function collectEntity(): SubscriptionPermissionName
    {

        $subscriptionPermissionNameEntity = new SubscriptionPermissionName();

        $subscriptionPermissionNameEntity
            ->setKey($this->request->get('key', ''))
            ->setTitleTranslationKey($this->request->get('title', ''));

        return $subscriptionPermissionNameEntity;

    }

}