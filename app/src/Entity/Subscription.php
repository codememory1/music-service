<?php

namespace App\Entity;

use App\Enum\RolePermissionNameEnum;
use App\Enum\StatusEnum;
use App\Interface\EntityInterface;
use App\Repository\SubscriptionRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use App\Validator\Constraints as AppAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class Subscription
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
#[ORM\Table('subscriptions')]
#[AppAssert\Authorization('common@authRequired', payload: 'not_authorized')]
#[AppAssert\UserPermission(
    RolePermissionNameEnum::CREATE_SUBSCRIPTION,
    'common@accessDenied',
    payload: 'not_enough_permissions'
)]
#[ORM\HasLifecycleCallbacks]
class Subscription implements EntityInterface
{

    use IdentifierTrait;
    use TimestampTrait;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Subscription name translation key'
    ])]
    private ?string $nameTranslationKey = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Subscription description translation key'
    ])]
    private ?string $descriptionTranslationKey = null;

    /**
     * @var float|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, options: [
        'comment' => 'Subscription price'
    ])]
    private ?float $price = null;

    /**
     * @var float|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true, options: [
        'comment' => 'Old subscription price'
    ])]
    private ?float $oldPrice = null;

    /**
     * @var int|null
     */
    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => 'Subscription status, default StatusEnum::ACTIVE'
    ])]
    private ?int $status;

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

    #[Pure]
    public function __construct()
    {

        $this->status = StatusEnum::ACTIVE->value;
        $this->subscriptionPermissions = new ArrayCollection();

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
