<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Repository\SubscriptionPaymentRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionPaymentRepository::class)]
#[ORM\Table('subscription_payments')]
#[ORM\HasLifecycleCallbacks]
class SubscriptionPayment implements EntityInterface
{
    use IdentifierTrait;
    use CreatedAtTrait;

    #[ORM\OneToOne(targetEntity: Transaction::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Transaction $transaction = null;

    #[ORM\ManyToOne(targetEntity: Subscription::class, inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscription $subscription = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: [
        'comment' => 'Date and time until which the subscription is valid'
    ])]
    private ?DateTimeImmutable $expiresAt = null;

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(Transaction $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getExpiresAt(): ?DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTimeImmutable $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
