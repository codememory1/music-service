<?php

namespace App\Service\Subscription\Permission;

use App\Entity\Subscription;
use App\Entity\SubscriptionPermission;
use App\Entity\SubscriptionPermissionName;
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
class CreatorPermissionService extends AbstractAddAndUpdatePermission
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

        // Check exist permission name
        $finedPermissionName = $this->existPermissionName();

        if ($finedPermissionName instanceof ApiResponseService) {
            return $finedPermissionName;
        }

        // Check exist subscription
        $finedSubscription = $this->existSubscription();

        if ($finedSubscription instanceof ApiResponseService) {
            return $finedSubscription;
        }

        $collectedEntity = $this->collectEntity($finedPermissionName, $finedSubscription);

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Calling an Extender Method
        return call_user_func($handler, $collectedEntity);

    }

    /**
     * @param SubscriptionPermissionName $subscriptionPermissionNameEntity
     * @param Subscription               $subscriptionEntity
     *
     * @return SubscriptionPermission
     */
    private function collectEntity(SubscriptionPermissionName $subscriptionPermissionNameEntity, Subscription $subscriptionEntity): SubscriptionPermission
    {

        $subscriptionPermission = new SubscriptionPermission();

        $subscriptionPermission
            ->setSubscriptionPermissionName($subscriptionPermissionNameEntity)
            ->setSubscription($subscriptionEntity);

        return $subscriptionPermission;

    }

}