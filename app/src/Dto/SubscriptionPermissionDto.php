<?php

namespace App\Dto;

use App\Entity\SubscriptionPermission;
use JetBrains\PhpStorm\Pure;

/**
 * Class SubscriptionRightDto
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
class SubscriptionPermissionDto
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
    #[Pure]
    public function transform(): array
    {

        $subscriptionPermissions = [];

        foreach ($this->data as $subscriptionPermission) {
            $subscriptionPermissions[] = [
                'id'    => $subscriptionPermission->getId(),
                'key'   => $subscriptionPermission->getSubscriptionPermissionName()->getKey(),
                'title' => $subscriptionPermission->getSubscriptionPermissionName()->getTitleTranslationKey(),
            ];
        }

        return $subscriptionPermissions;

    }

}