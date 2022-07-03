<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\SubscriptionPermissionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SubscriptionPermission.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: SubscriptionPermissionRepository::class)]
#[ORM\Table('subscription_permissions')]
#[ORM\HasLifecycleCallbacks]
class SubscriptionPermission implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Subscription::class, inversedBy: 'permissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscription $subscription = null;

    #[ORM\ManyToOne(targetEntity: SubscriptionPermissionKey::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?SubscriptionPermissionKey $subscriptionPermissionKey = null;

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getPermissionKey(): ?SubscriptionPermissionKey
    {
        return $this->subscriptionPermissionKey;
    }

    public function setPermissionKey(?SubscriptionPermissionKey $subscriptionPermissionKey): self
    {
        $this->subscriptionPermissionKey = $subscriptionPermissionKey;

        return $this;
    }
}
