<?php

namespace App\Service\Subscription\Permission;

use App\Entity\Subscription;
use App\Entity\SubscriptionPermissionName;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\SubscriptionPermissionNameRepository;
use App\Repository\SubscriptionRepository;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class AbstractAddAndUpdatePermission
 *
 * @package App\Service\Subscription\Permission
 *
 * @author  Codememory
 */
abstract class AbstractAddAndUpdatePermission extends AbstractApiService
{

    /**
     * @return ApiResponseService|SubscriptionPermissionName
     * @throws Exception
     */
    protected function existPermissionName(): ApiResponseService|SubscriptionPermissionName
    {

        /** @var SubscriptionPermissionNameRepository $subscriptionPermissionNameRepository */
        $subscriptionPermissionNameRepository = $this->em->getRepository(SubscriptionPermissionName::class);
        $finedPermissionName = $subscriptionPermissionNameRepository->findOneBy([
            'key' => $this->request->get('permission_name')
        ]);

        if (null == $finedPermissionName) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'permission_name_not_exist',
                    $this->getTranslation('subscriptionPermissionName@notExist')
                );

            return $this->getPreparedApiResponse();
        }

        return $finedPermissionName;

    }

    /**
     * @return ApiResponseService|Subscription
     * @throws Exception
     */
    protected function existSubscription(): ApiResponseService|Subscription
    {

        /** @var SubscriptionRepository $subscriptionRepository */
        $subscriptionRepository = $this->em->getRepository(Subscription::class);
        $finedSubscription = $subscriptionRepository->findOneBy([
            'id' => $this->request->get('subscription')
        ]);

        if (null == $finedSubscription) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'subscription_not_exist',
                    $this->getTranslation('subscription@notExist')
                );

            return $this->getPreparedApiResponse();
        }

        return $finedSubscription;

    }

}