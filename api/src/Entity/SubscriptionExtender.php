<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Repository\SubscriptionExtenderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionExtenderRepository::class)]
#[ORM\Table('subscription_extenders')]
#[ORM\HasLifecycleCallbacks]
class SubscriptionExtender implements EntityInterface
{
    use IdentifierTrait;
    use CreatedAtTrait;

    #[ORM\ManyToOne(targetEntity: Subscription::class, inversedBy: 'extenders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscription $subscription = null;

    #[ORM\ManyToOne(targetEntity: Subscription::class)]
    private ?Subscription $basicSubscription = null;

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getBasicSubscription(): ?Subscription
    {
        return $this->basicSubscription;
    }

    public function setBasicSubscription(?Subscription $basicSubscription): self
    {
        $this->basicSubscription = $basicSubscription;

        return $this;
    }
}
