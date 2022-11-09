<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionStatusEnum;
use App\Infrastructure\Validator\Validator;
use App\Repository\SubscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
#[ORM\Table('subscriptions')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('key', 'entityExist@subscription', payload: [Validator::PPC => PlatformCodeEnum::ENTITY_FOUND])]
class Subscription implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

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

    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: SubscriptionPermission::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $permissions;

    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: SubscriptionPayment::class, cascade: ['remove'])]
    private Collection $payments;

    #[Pure]
    public function __construct()
    {
        $this->permissions = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->titleTranslationKey;
    }

    public function setTitle(?string $titleTranslationKey): self
    {
        $this->titleTranslationKey = $titleTranslationKey;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->descriptionTranslationKey;
    }

    public function setDescription(?string $descriptionTranslationKey): self
    {
        $this->descriptionTranslationKey = $descriptionTranslationKey;

        return $this;
    }

    public function getOldPrice(): ?float
    {
        return $this->oldPrice;
    }

    public function setOldPrice(?float $oldPrice): self
    {
        $this->oldPrice = $oldPrice;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function isRecommend(): ?bool
    {
        return $this->isRecommend;
    }

    public function setIsRecommend(?bool $isRecommend): self
    {
        $this->isRecommend = $isRecommend;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?SubscriptionStatusEnum $statusEnum): self
    {
        if (null === $statusEnum) {
            $this->status = SubscriptionStatusEnum::HIDE->name;
        } else {
            $this->status = $statusEnum?->name;
        }

        return $this;
    }

    public function setHideStatus(): self
    {
        $this->setStatus(SubscriptionStatusEnum::HIDE);

        return $this;
    }

    #[Pure]
    public function isHide(): bool
    {
        return $this->getStatus() === SubscriptionStatusEnum::HIDE->name;
    }

    public function setShowStatus(): self
    {
        $this->setStatus(SubscriptionStatusEnum::SHOW);

        return $this;
    }

    #[Pure]
    public function isShow(): bool
    {
        return $this->getStatus() === SubscriptionStatusEnum::SHOW->name;
    }

    /**
     * @return Collection<int, SubscriptionPermission>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    /**
     * @param array<SubscriptionPermissionKey> $permissionKeys
     */
    public function setPermissions(array $permissionKeys): self
    {
        $permissions = [];

        foreach ($permissionKeys as $permissionKey) {
            $subscriptionPermission = new SubscriptionPermission();

            $subscriptionPermission->setSubscription($this);
            $subscriptionPermission->setPermissionKey($permissionKey);

            $permissions[] = $subscriptionPermission;
        }

        $this->permissions = new ArrayCollection($permissions);

        return $this;
    }

    public function addPermission(SubscriptionPermission $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
            $permission->setSubscription($this);
        }

        return $this;
    }

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

    /**
     * @return Collection<int, SubscriptionPayment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }
}
