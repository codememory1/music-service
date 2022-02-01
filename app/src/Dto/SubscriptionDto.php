<?php

namespace App\Dto;

use App\Entity\Subscription;

/**
 * Class SubscriptionDto
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
class SubscriptionDto implements DtoInterface
{

    /**
     * @var Subscription[]
     */
    private array $data;

    /**
     * @param Subscription[] $data
     */
    public function __construct(array $data)
    {

        $this->data = $data;

    }

    /**
     * @inheritDoc
     */
    public function transform(): array
    {

        $subscriptions = [];

        foreach ($this->data as $subscription) {
            $permissions = $subscription->getSubscriptionPermissions()->getValues();
            $oldPrice = $subscription->getOldPrice();

            $subscriptions[] = [
                'id'          => $subscription->getId(),
                'name'        => $subscription->getNameTranslationKey(),
                'description' => $subscription->getDescriptionTranslationKey(),
                'price'       => (float) $subscription->getPrice(),
                'old_price'   => empty($oldPrice) ? null : (float) $oldPrice,
                'status'      => $subscription->getStatus(),
                'permissions' => (new SubscriptionPermissionDto($permissions))->transform()
            ];
        }

        return $subscriptions;

    }

}