<?php

namespace App\Entity;

use App\Enums\StatusEnum;
use App\Repository\SubscriptionRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Subscription
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
#[ORM\Table('subscriptions')]
class Subscription
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, options: [
        'comment' => 'Subscription name translation key'
    ])]
    #[Assert\NotBlank(message: 'subscription@nameIsRequired', payload: 'name_is_required')]
    #[Assert\Length(max: 255, maxMessage: 'subscription@nameMaxLength', payload: 'name_length')]
    private ?string $nameTranslationKey = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, options: [
        'comment' => 'Subscription description translation key'
    ])]
    #[Assert\NotBlank(message: 'common@descriptionIsRequired', payload: 'description_is_required')]
    #[Assert\Length(max: 255, maxMessage: 'subscription@descriptionMaxLength', payload: 'description_length')]
    private ?string $descriptionTranslationKey = null;

    /**
     * @var float|null
     */
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, options: [
        'comment' => 'Subscription price'
    ])]
    #[Assert\NotBlank(message: 'common@priceIsRequired', payload: 'price_is_required')]
    #[Assert\PositiveOrZero(message: 'common@priceInvalid', payload: 'price_invalid')]
    private ?float $price = null;

    /**
     * @var float|null
     */
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true, options: [
        'comment' => 'Old subscription price'
    ])]
    #[Assert\NotBlank(message: 'common@priceIsRequired', payload: 'old_price_is_required')]
    #[Assert\PositiveOrZero(message: 'common@priceInvalid', payload: 'old_price_invalid')]
    private ?float $oldPrice = null;

    /**
     * @var int|null
     */
    #[ORM\Column(type: 'integer', options: [
        'comment' => 'Subscription status, default StatusEnum::ACTIVE'
    ])]
    #[Assert\NotBlank(message: 'common@statusIsRequired', payload: 'status_is_required')]
    #[Assert\Choice(callback: [StatusEnum::class, 'values'], message: 'common@statusInvalid', payload: 'status_invalid')]
    private ?int $status;

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

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: SubscriptionRight::class)]
    private Collection $subscriptionRights;

    /**
     * @var UserSubscription|null
     */
    #[ORM\OneToOne(mappedBy: 'subscription', targetEntity: UserSubscription::class, cascade: ['persist', 'remove'])]
    private ?UserSubscription $userSubscription = null;

    public function __construct()
    {

        $this->status = StatusEnum::ACTIVE->value;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->subscriptionRights = new ArrayCollection();

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @return string|null
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
     * @return string|null
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
     * @return string|null
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

        $this->price = $price;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getOldPrice(): ?string
    {

        return $this->oldPrice;

    }

    /**
     * @param string $oldPrice
     *
     * @return $this
     */
    public function setOldPrice(string $oldPrice): self
    {

        $this->oldPrice = $oldPrice;

        return $this;

    }

    /**
     * @return int|null
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

    /**
     * @return Collection
     */
    public function getSubscriptionRights(): Collection
    {

        return $this->subscriptionRights;

    }

    /**
     * @param SubscriptionRight $subscriptionRight
     *
     * @return $this
     */
    public function addSubscriptionRight(SubscriptionRight $subscriptionRight): self
    {

        if (!$this->subscriptionRights->contains($subscriptionRight)) {
            $this->subscriptionRights[] = $subscriptionRight;
            $subscriptionRight->setSubscription($this);
        }

        return $this;

    }

    /**
     * @param SubscriptionRight $subscriptionRight
     *
     * @return $this
     */
    public function removeSubscriptionRight(SubscriptionRight $subscriptionRight): self
    {

        if ($this->subscriptionRights->removeElement($subscriptionRight)) {
            // set the owning side to null (unless already changed)
            if ($subscriptionRight->getSubscription() === $this) {
                $subscriptionRight->setSubscription(null);
            }
        }

        return $this;

    }

    /**
     * @return UserSubscription|null
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
