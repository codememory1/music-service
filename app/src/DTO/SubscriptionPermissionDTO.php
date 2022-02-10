<?php

namespace App\DTO;

use App\Entity\Subscription;
use App\Entity\SubscriptionPermission;
use App\Entity\SubscriptionPermissionName;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SubscriptionPermissionDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class SubscriptionPermissionDTO extends AbstractDTO
{

    /**
     * @var array|string[]
     */
    protected array $requestKeys = [
        'subscription_permission_name',
        'subscription'
    ];

    /**
     * @var array
     */
    protected array $valueAsEntity = [
        'subscription_permission_name' => [SubscriptionPermissionName::class, 'key'],
        'subscription'                 => [Subscription::class, 'id'],
    ];

    /**
     * @var string|null
     */
    protected ?string $entityClass = SubscriptionPermission::class;

    /**
     * @var SubscriptionPermissionName|null
     */
    #[Assert\NotBlank(
        message: 'subscriptionPermission@permissionNameNotExistOrNotEntered',
        payload: 'right_name_not_exist_or_not_entered'
    )]
    private ?SubscriptionPermissionName $subscriptionPermissionName = null;

    /**
     * @var Subscription|null
     */
    #[Assert\NotBlank(
        message: 'subscriptionPermission@subscriptionNotExistOrNotEnetred',
        payload: 'subscription_not_exist_or_not_entered'
    )]
    private ?Subscription $subscription = null;

    /**
     * @param SubscriptionPermission $subscriptionPermission
     * @param array                  $exclude
     *
     * @return array
     */
    #[ArrayShape([
        'id'              => "int|null",
        'permission_name' => "mixed",
        'created_at'      => "string",
        'updated_at'      => "null|string"
    ])]
    public function toArray(SubscriptionPermission $subscriptionPermission, array $exclude = []): array
    {

        $permissionName = $subscriptionPermission->getSubscriptionPermissionName();

        $subscriptionPermission = [
            'id'              => $subscriptionPermission->getId(),
            'permission_name' => (new SubscriptionPermissionNameDTO())->toArray($permissionName),
            'created_at'      => $subscriptionPermission->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at'      => $subscriptionPermission->getCreatedAt()?->format('Y-m-d H:i:s'),
        ];

        $this->excludeKeys($subscriptionPermission, $exclude);

        return $subscriptionPermission;

    }

    /**
     * @param SubscriptionPermissionName|null $subscriptionPermissionName
     *
     * @return SubscriptionPermissionDTO
     */
    public function setSubscriptionPermissionName(?SubscriptionPermissionName $subscriptionPermissionName): self
    {

        $this->subscriptionPermissionName = $subscriptionPermissionName;

        return $this;

    }

    /**
     * @return SubscriptionPermissionName|null
     */
    public function getSubscriptionPermissionName(): ?SubscriptionPermissionName
    {

        return $this->subscriptionPermissionName;

    }

    /**
     * @param Subscription|null $subscription
     *
     * @return SubscriptionPermissionDTO
     */
    public function setSubscription(?Subscription $subscription): self
    {

        $this->subscription = $subscription;

        return $this;

    }

    /**
     * @return Subscription|null
     */
    public function getSubscription(): ?Subscription
    {

        return $this->subscription;

    }

}