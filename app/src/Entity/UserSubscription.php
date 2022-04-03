<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\UserSubscriptionRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserSubscription.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserSubscriptionRepository::class)]
#[ORM\Table('user_subscriptions')]
#[ORM\HasLifecycleCallbacks]
class UserSubscription implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|User
     */
    #[ORM\OneToOne(inversedBy: 'userSubscription', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var null|Subscription
     */
    #[ORM\OneToOne(inversedBy: 'userSubscription', targetEntity: Subscription::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscription $subscription = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Subscription duration in the format 30d 10m, etc.'
    ])]
    private ?string $validTo = null;

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

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
     * @param Subscription $subscription
     *
     * @return $this
     */
    public function setSubscription(Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getValidTo(): ?string
    {
        return $this->validTo;
    }

    /**
     * @param string $validTo
     *
     * @return $this
     */
    public function setValidTo(string $validTo): self
    {
        $this->validTo = $validTo;

        return $this;
    }
}
