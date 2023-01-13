<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
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

    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: SubscriptionUiPermission::class, cascade: ['persist', 'remove'])]
    private Collection $uiPermissions;

    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: SubscriptionPayment::class, cascade: ['remove'])]
    private Collection $payments;

    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: SubscriptionExtender::class, cascade: ['persist', 'remove'])]
    private Collection $extenders;

    #[Pure]
    public function __construct()
    {
        $this->permissions = new ArrayCollection();
        $this->uiPermissions = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->extenders = new ArrayCollection();
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

    public function isHide(): bool
    {
        return $this->getStatus() === SubscriptionStatusEnum::HIDE->name;
    }

    public function setShowStatus(): self
    {
        $this->setStatus(SubscriptionStatusEnum::SHOW);

        return $this;
    }

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

    public function getUniquePermissions(): Collection
    {
        if ($this->extenders->isEmpty()) {
            return $this->permissions;
        }

        $uniquePermissions = new ArrayCollection();

        foreach ($this->getPermissions() as $permission) {
            foreach ($this->getExtenders() as $extender) {
                $extenderHasPermission = $extender
                    ->getBasicSubscription()
                    ->getPermissions()
                    ->exists(static fn(int $key, SubscriptionPermission $permissionFromBasic) => $permissionFromBasic->getPermissionKey()->isCompare($permission->getPermissionKey()));

                if (!$extenderHasPermission) {
                    $uniquePermissions->add($permission);
                }
            }
        }

        return $uniquePermissions;
    }

    public function getPermission(SubscriptionPermissionEnum $subscriptionPermission): ?SubscriptionPermission
    {
        foreach ($this->getPermissions() as $permission) {
            if ($permission->getPermissionKey()->getKey() === $subscriptionPermission->name) {
                return $permission;
            }
        }

        return null;
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
     * @return Collection<int, SubscriptionUiPermission>
     */
    public function getUiPermissions(): Collection
    {
        return $this->uiPermissions;
    }

    public function addUiPermissions(SubscriptionUiPermission $uiPermissions): self
    {
        if (!$this->uiPermissions->contains($uiPermissions)) {
            $this->uiPermissions[] = $uiPermissions;
            $uiPermissions->setSubscription($this);
        }

        return $this;
    }

    public function removeUiPermissions2(SubscriptionUiPermission $uiPermissions): self
    {
        if ($this->uiPermissions->removeElement($uiPermissions)) {
            // set the owning side to null (unless already changed)
            if ($uiPermissions->getSubscription() === $this) {
                $uiPermissions->setSubscription(null);
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

    /**
     * @return Collection<int, SubscriptionExtender>
     */
    public function getExtenders(): Collection
    {
        return $this->extenders;
    }

    public function addExtender(SubscriptionExtender $extender): self
    {
        if (!$this->extenders->contains($extender)) {
            $this->extenders[] = $extender;
            $extender->setSubscription($this);
        }

        return $this;
    }

    public function removeExtender(SubscriptionExtender $extender): self
    {
        if ($this->extenders->removeElement($extender)) {
            // set the owning side to null (unless already changed)
            if ($extender->getSubscription() === $this) {
                $extender->setSubscription(null);
            }
        }

        return $this;
    }
}
