<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\ResponseTypeEnum;
use App\Enum\SubscriptionStatusEnum;
use App\Repository\SubscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

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
#[UniqueEntity('key', 'entityExist@subscription', payload: [ResponseTypeEnum::EXIST, 409])]
class Subscription implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'Unique subscription key for identification'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Name in the form of a translation key'
    ])]
    private ?string $titleTranslationKey = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Description in the form of a translation key'
    ])]
    private ?string $descriptionTranslationKey = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true, options: [
        'comment' => 'Old subscription price'
    ])]
    private ?float $oldPrice = null;

    #[ORM\Column(type: Types::FLOAT, options: [
        'comment' => 'Subscription sale price'
    ])]
    private ?float $price = null;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        'comment' => 'Whether to recommend this subscription'
    ])]
    private ?bool $isRecommend = false;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Subscription status from SubscriptionStatusEnum'
    ])]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: SubscriptionPermission::class, orphanRemoval: true)]
    private Collection $permissions;

    #[Pure]
    public function __construct()
    {
        $this->permissions = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param null|string $key
     *
     * @return $this
     */
    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitleTranslationKey(): ?string
    {
        return $this->titleTranslationKey;
    }

    /**
     * @param null|string $titleTranslationKey
     *
     * @return $this
     */
    public function setTitleTranslationKey(?string $titleTranslationKey): self
    {
        $this->titleTranslationKey = $titleTranslationKey;

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
     * @param null|string $descriptionTranslationKey
     *
     * @return $this
     */
    public function setDescriptionTranslationKey(?string $descriptionTranslationKey): self
    {
        $this->descriptionTranslationKey = $descriptionTranslationKey;

        return $this;
    }

    /**
     * @return null|float
     */
    public function getOldPrice(): ?float
    {
        return $this->oldPrice;
    }

    /**
     * @param null|float $oldPrice
     *
     * @return $this
     */
    public function setOldPrice(?float $oldPrice): self
    {
        $this->oldPrice = $oldPrice;

        return $this;
    }

    /**
     * @return null|float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param null|float $price
     *
     * @return $this
     */
    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return null|bool
     */
    public function isIsRecommend(): ?bool
    {
        return $this->isRecommend;
    }

    /**
     * @param null|bool $isRecommend
     *
     * @return $this
     */
    public function setIsRecommend(?bool $isRecommend): self
    {
        $this->isRecommend = $isRecommend;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param null|SubscriptionStatusEnum $statusEnum
     *
     * @return $this
     */
    public function setStatus(?SubscriptionStatusEnum $statusEnum): self
    {
        $this->status = $statusEnum->name;

        return $this;
    }

    /**
     * @return Collection<int, SubscriptionPermission>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    /**
     * @param SubscriptionPermission $permission
     *
     * @return $this
     */
    public function addPermission(SubscriptionPermission $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
            $permission->setSubscription($this);
        }

        return $this;
    }

    /**
     * @param SubscriptionPermission $permission
     *
     * @return $this
     */
    public function removePermission(SubscriptionPermission $permission): self
    {
        if ($this->permissions->removeElement($permission)) {
            // set the owning side to null (unless already changed)
            if ($permission->getSubscription() === $this) {
                $permission->setSubscription(null);
            }
        }

        return $this;
    }
}
