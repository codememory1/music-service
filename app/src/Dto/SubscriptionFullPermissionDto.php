<?php

namespace App\Dto;

use App\Entity\SubscriptionPermission;

/**
 * Class SubscriptionFullPermissionDto
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
class SubscriptionFullPermissionDto
{

    /**
     * @var SubscriptionPermission[]
     */
    private array $data;

    /**
     * @param SubscriptionPermission[] $data
     */
    public function __construct(array $data)
    {

        $this->data = $data;

    }

    /**
     * @return array
     */
    public function transform(): array
    {

        $subscriptionPermissions = [];

        foreach ($this->data as $subscriptionPermission) {
            $permissionName = $subscriptionPermission->getSubscriptionPermissionName();
            $subscription = $subscriptionPermission->getSubscription();

            $subscriptionPermissions[] = [
                'id'              => $subscriptionPermission->getId(),
                'permission_name' => [
                    'id'    => $permissionName->getId(),
                    'key'   => $permissionName->getKey(),
                    'title' => $permissionName->getTitleTranslationKey(),
                ],
                'subscription'    => [
                    'id'   => $subscription->getId(),
                    'name' => $subscription->getNameTranslationKey(),
                ]
            ];
        }

        return $subscriptionPermissions;

    }

}