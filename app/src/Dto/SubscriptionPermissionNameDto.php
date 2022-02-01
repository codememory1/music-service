<?php

namespace App\Dto;

use App\Entity\SubscriptionPermissionName;
use JetBrains\PhpStorm\Pure;

/**
 * Class SubscriptionPermissionNameDto
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
class SubscriptionPermissionNameDto
{

    /**
     * @var SubscriptionPermissionName[]
     */
    private array $data;

    /**
     * @param SubscriptionPermissionName[] $data
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

        $subscriptionPermissionNames = [];

        foreach ($this->data as $subscriptionPermissionName) {
            $subscriptionPermissionNames[] = [
                'id'    => $subscriptionPermissionName->getId(),
                'key'   => $subscriptionPermissionName->getKey(),
                'title' => $subscriptionPermissionName->getTitleTranslationKey(),
            ];
        }

        return $subscriptionPermissionNames;

    }

}