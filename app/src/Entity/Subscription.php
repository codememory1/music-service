<?php

namespace App\Entity;

use App\Enums\ApiResponseTypeEnum;
use App\Enums\StatusEnum;
use App\Repository\SubscriptionRepository;
use App\ValidatorConstraints as AppAssert;
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
    #[AppAssert\Exist(TranslationKey::class, 'name', 'common@titleTranslationKeyNotExist', [ApiResponseTypeEnum::CHECK_EXIST, 'title_translation_key_not_exist'])]
    private ?string $nameTranslationKey = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, options: [
        'comment' => 'Subscription description translation key'
    ])]
    #[Assert\NotBlank(message: 'common@descriptionIsRequired', payload: 'description_is_required')]
    #[Assert\Length(max: 255, maxMessage: 'subscription@descriptionMaxLength', payload: 'description_length')]
    #[AppAssert\Exist(TranslationKey::class, 'name', 'common@descriptionTranslationKeyNotExist', [ApiResponseTypeEnum::CHECK_EXIST, 'description_translation_key_not_exist'])]
    private ?string $descriptionTranslationKey = null;

    /**
     * @var float|null
     */
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, options: [
        'comment' => 'Subscription price'
    ])]
    #[Assert\NotBlank(message: 'common@priceIsRequired', payload: 'price_is_required')]
    private ?float $price = null;

    /**
     * @var float|null
     */
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true, options: [
        'comment' => 'Old subscription price'
    ])]
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
    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: SubscriptionPermission::class)]
    private Collection $subscriptionPermissions;

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
        $this->subscriptionPermissions = new ArrayCollection();

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

        $this->price = (float) $price;

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
     * @param string|null $oldPrice
     *
     * @return $this
     */
    public function setOldPrice(?string $oldPrice): self
    {

        $this->oldPrice = empty($oldPrice) ? null : (float) $oldPrice;

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
    public function getSubscriptionPermissions(): Collection
    {

        return $this->subscriptionPermissions;

    }

    /**
     * @param SubscriptionPermission $subscriptionPermission
     *
     * @return $this
     */
    public function addSubscriptionRight(SubscriptionPermission $subscriptionPermission): self
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
    public function removeSubscriptionRight(SubscriptionPermission $subscriptionPermission): self
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
