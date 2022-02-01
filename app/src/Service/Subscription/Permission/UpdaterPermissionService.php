<?php

namespace App\Service\Subscription\Permission;

use App\Entity\Subscription;
use App\Entity\SubscriptionPermission;
use App\Entity\SubscriptionPermissionName;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\SubscriptionPermissionRepository;
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
class UpdaterPermissionService extends AbstractAddAndUpdatePermission
{

    /**
     * @param int                $id
     * @param ValidatorInterface $validator
     * @param callable           $handler
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function update(int $id, ValidatorInterface $validator, callable $handler): ApiResponseService
    {

        // Check exist permission
        /** @var SubscriptionPermissionRepository $subscriptionPermissionRepository */
        $subscriptionPermissionRepository = $this->em->getRepository(SubscriptionPermission::class);

        // Check exist language
        if (null === $finedPermission = $subscriptionPermissionRepository->findOneBy(['id' => $id])) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'subscription_not_exist',
                    $this->getTranslation('subscriptionPermission@notExist')
                );

            return $this->getPreparedApiResponse();
        }

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

        $collectedEntity = $this->collectEntity($finedPermission, $finedPermissionName, $finedSubscription);

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Calling an Extender Method
        return call_user_func($handler, $collectedEntity);

    }

    /**
     * @param SubscriptionPermission     $subscriptionPermissionEntity
     * @param SubscriptionPermissionName $subscriptionPermissionNameEntity
     * @param Subscription               $subscriptionEntity
     *
     * @return SubscriptionPermission
     */
    private function collectEntity(SubscriptionPermission $subscriptionPermissionEntity, SubscriptionPermissionName $subscriptionPermissionNameEntity, Subscription $subscriptionEntity): SubscriptionPermission
    {

        $subscriptionPermissionEntity
            ->setSubscriptionPermissionName($subscriptionPermissionNameEntity)
            ->setSubscription($subscriptionEntity);

        return $subscriptionPermissionEntity;

    }

}