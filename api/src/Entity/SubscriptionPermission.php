<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\SubscriptionPermissionRepository;
use App\Traits\Entity\IdentifierTrait;
use App\Traits\Entity\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class SubscriptionPermission.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: SubscriptionPermissionRepository::class)]
#[ORM\Table('subscription_permissions')]
#[UniqueEntity(
    ['subscriptionPermissionName', 'subscription'],
    'subscriptionPermission@exist',
    payload: ApiResponseTypeEnum::CHECK_EXIST
)]
#[ORM\HasLifecycleCallbacks]
class SubscriptionPermission implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|SubscriptionPermissionName
     */
    #[ORM\ManyToOne(
        targetEntity: SubscriptionPermissionName::class,
        cascade: ['persist', 'remove'],
        inversedBy: 'subscriptionPermissions'
    )
    ]
    #[ORM\JoinColumn(nullable: false)]
    private ?SubscriptionPermissionName $subscriptionPermissionName = null;

    /**
     * @var null|Subscription
     */
    #[ORM\ManyToOne(targetEntity: Subscription::class, inversedBy: 'subscriptionPermissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscription $subscription = null;

    /**
     * @return null|SubscriptionPermissionName
     */
    public function getSubscriptionPermissionName(): ?SubscriptionPermissionName
    {
        return $this->subscriptionPermissionName;
    }

    /**
     * @param null|SubscriptionPermissionName $subscriptionPermissionName
     *
     * @return $this
     */
    public function setSubscriptionPermissionName(?SubscriptionPermissionName $subscriptionPermissionName): self
    {
        $this->subscriptionPermissionName = $subscriptionPermissionName;

        return $this;
    }

    /**
     * @return null|Subscription
     */
    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    /**
     * @param null|Subscription $subscription
     *
     * @return $this
     */
    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }
}
