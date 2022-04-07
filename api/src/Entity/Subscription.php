<?php

namespace App\Entity;

use App\Enum\StatusEnum;
use App\Interfaces\EntityInterface;
use App\Repository\SubscriptionRepository;
use App\Traits\Entity\IdentifierTrait;
use App\Traits\Entity\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class Subscription.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
#[ORM\Table('subscriptions')]
#[ORM\HasLifecycleCallbacks]
class Subscription implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 50, unique: true, options: [
        'comment' => 'Key for check'
    ])]
    private ?string $key = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Subscription name translation key'
    ])]
    private ?string $nameTranslationKey = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Subscription description translation key'
    ])]
    private ?string $descriptionTranslationKey = null;

    /**
     * @var null|float
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, options: [
        'comment' => 'Subscription price'
    ])]
    private ?float $price = null;

    /**
     * @var null|float
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true, options: [
        'comment' => 'Old subscription price'
    ])]
    private ?float $oldPrice = null;

    /**
     * @var null|int
     */
    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => 'Subscription status, default StatusEnum::ACTIVE'
    ])]
    private ?int $status;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: SubscriptionPermission::class, cascade: ['persist', 'remove'])]
    private Collection $subscriptionPermissions;

    /**
     * @var null|UserSubscription
     */
    #[ORM\OneToOne(mappedBy: 'subscription', targetEntity: UserSubscription::class, cascade: ['persist', 'remove'])]
    private ?UserSubscription $userSubscription = null;

    #[Pure]
    public function __construct()
    {
        $this->status = StatusEnum::ACTIVE->value;
        $this->subscriptionPermissions = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getNameTranslationKey(): ?string
    {
        return $this->nameTranslationKey;
    }

    /**
     * @param string $nameTranslationKey
     *
     * @return $this
     */
    public function setNameTranslationKey(string $nameTranslationKey): self
    {
        $this->nameTranslationKey = $nameTranslationKey;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescriptionTranslationKey(): ?string
    {
        return $this->descriptionTranslationKey;
    }

    /**
     * @param string $descriptionTranslationKey
     *
     * @return $this
     */
    public function setDescriptionTranslationKey(string $descriptionTranslationKey): self
    {
        $this->descriptionTranslationKey = $descriptionTranslationKey;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string $price
     *
     * @return $this
     */
    public function setPrice(string $price): self
    {
        $this->price = (float) $price;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getOldPrice(): ?string
    {
        return $this->oldPrice;
    }

    /**
     * @param null|string $oldPrice
     *
     * @return $this
     */
    public function setOldPrice(?string $oldPrice): self
    {
        $this->oldPrice = empty($oldPrice) ? null : (float) $oldPrice;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPermissions(): Collection
    {
        return $this->subscriptionPermissions;
    }

    /**
     * @param SubscriptionPermission $subscriptionPermission
     *
     * @return $this
     */
    public function addPermissions(SubscriptionPermission $subscriptionPermission): self
    {
        if (!$this->subscriptionPermissions->contains($subscriptionPermission)) {
            $this->subscriptionPermissions[] = $subscriptionPermission;
            $subscriptionPermission->setSubscription($this);
        }

        return $this;
    }

    /**
     * @param SubscriptionPermission $subscriptionPermission
     *
     * @return $this
     */
    public function removePermission(SubscriptionPermission $subscriptionPermission): self
    {
        if ($this->subscriptionPermissions->removeElement($subscriptionPermission)) {
            // set the owning side to null (unless already changed)
            if ($subscriptionPermission->getSubscription() === $this) {
                $subscriptionPermission->setSubscription(null);
            }
        }

        return $this;
    }

    /**
     * @return null|UserSubscription
     */
    public function getUserSubscription(): ?UserSubscription
    {
        return $this->userSubscription;
    }

    /**
     * @param UserSubscription $userSubscription
     *
     * @return $this
     */
    public function setUserSubscription(UserSubscription $userSubscription): self
    {
        // set the owning side of the relation if necessary
        if ($userSubscription->getSubscription() !== $this) {
            $userSubscription->setSubscription($this);
        }

        $this->userSubscription = $userSubscription;

        return $this;
    }
}
