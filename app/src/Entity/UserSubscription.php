<?php

namespace App\Entity;

use App\Repository\UserSubscriptionRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserSubscription
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserSubscriptionRepository::class)]
#[ORM\Table('user_subscriptions')]
class UserSubscription
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var User|null
     */
    #[ORM\OneToOne(inversedBy: 'userSubscription', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'common@userIsRequired', payload: 'user_is_required')]
    private ?User $user = null;

    /**
     * @var Subscription|null
     */
    #[ORM\OneToOne(inversedBy: 'userSubscription', targetEntity: Subscription::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'common@subscriptionIsRequired', payload: 'subscription_is_required')]
    private ?Subscription $subscription = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, options: [
        'comment' => 'Subscription duration in the format 30d 10m, etc.'
    ])]
    #[Assert\NotBlank(message: 'common@validToIsRequired', payload: 'valid_to_is_required')]
    #[Assert\Regex('\d+(y|m|w|d||h|m|s)', message: 'common@invalidValidTo', payload: 'valid_to_invalid')]
    private ?string $validTo = null;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $updatedAt;

    public function __construct()
    {

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @return User|null
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
     * @return Subscription|null
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
     * @return string|null
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

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {

        return $this->createdAt;

    }

    /**
     * @param DateTimeImmutable $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {

        $this->createdAt = $createdAt;

        return $this;

    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getUpdatedAt(): ?DateTimeImmutable
    {

        return $this->updatedAt;

    }

    /**
     * @param DateTimeImmutable $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {

        $this->updatedAt = $updatedAt;

        return $this;

    }

}
