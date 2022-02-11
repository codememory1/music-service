<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Enum\RolePermissionNameEnum;
use App\Interface\EntityInterface;
use App\Repository\SubscriptionPermissionRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class SubscriptionPermission
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
    payload: [ApiResponseTypeEnum::CHECK_EXIST, 'permission_exist']
)]
#[AppAssert\Authorization('common@authRequired', payload: 'not_authorized')]
#[AppAssert\UserPermission(
    RolePermissionNameEnum::CREATE_SUBSCRIPTION,
    'common@accessDenied',
    payload: 'not_enough_permissions'
)]
#[ORM\HasLifecycleCallbacks]
class SubscriptionPermission implements EntityInterface
{

    use IdentifierTrait;
    use TimestampTrait;

    /**
     * @var SubscriptionPermissionName|null
     */
    #[ORM\ManyToOne(targetEntity: SubscriptionPermissionName::class, inversedBy: 'subscriptionPermissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SubscriptionPermissionName $subscriptionPermissionName = null;

    /**
     * @var Subscription|null
     */
    #[ORM\ManyToOne(targetEntity: Subscription::class, inversedBy: 'subscriptionPermissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscription $subscription = null;

    /**
     * @return SubscriptionPermissionName|null
     */
    public function getSubscriptionPermissionName(): ?SubscriptionPermissionName
    {

        return $this->subscriptionPermissionName;

    }

    /**
     * @param SubscriptionPermissionName|null $subscriptionPermissionName
     *
     * @return $this
     */
    public function setSubscriptionPermissionName(?SubscriptionPermissionName $subscriptionPermissionName): self
    {

        $this->subscriptionPermissionName = $subscriptionPermissionName;

        return $this;

    }

    /**
     * @return Subscription|null
     */
    public function getSubscription(): ?Subscription
    {

        return $this->subscription;

    }

    /**
     * @param Subscription|null $subscription
     *
     * @return $this
     */
    public function setSubscription(?Subscription $subscription): self
    {

        $this->subscription = $subscription;

        return $this;

    }

}
