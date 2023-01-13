<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\SubscriptionPermissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionPermissionRepository::class)]
#[ORM\Table('subscription_permissions')]
#[ORM\HasLifecycleCallbacks]
class SubscriptionPermission implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\ManyToOne(targetEntity: Subscription::class, inversedBy: 'permissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscription $subscription = null;

    #[ORM\ManyToOne(targetEntity: SubscriptionPermissionKey::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?SubscriptionPermissionKey $subscriptionPermissionKey = null;

    #[ORM\Column(type: Types::JSON, nullable: true, options: [
        'comment' => 'Subscription permission value'
    ])]
    private array $value = [];

    #[ORM\OneToMany(mappedBy: 'permission', targetEntity: SubscriptionUiPermission::class, cascade: ['remove'])]
    private Collection $uiPermissions;

    public function __construct()
    {
        $this->uiPermissions = new ArrayCollection();
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

    public function getPermissionKey(): ?SubscriptionPermissionKey
    {
        return $this->subscriptionPermissionKey;
    }

    public function setPermissionKey(?SubscriptionPermissionKey $subscriptionPermissionKey): self
    {
        $this->subscriptionPermissionKey = $subscriptionPermissionKey;

        return $this;
    }

    public function getValue(bool $first = false): mixed
    {
        if ($first) {
            return count($this->value) > 0 ? $this->value[array_key_first($this->value)] : null;
        }

        return $this->value;
    }

    public function setValue(array $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, SubscriptionUiPermission>
     */
    public function getUiPermissions(): Collection
    {
        return $this->uiPermissions;
    }

    public function addUiPermission(SubscriptionUiPermission $uiPermission): self
    {
        if (!$this->uiPermissions->contains($uiPermission)) {
            $this->uiPermissions[] = $uiPermission;
            $uiPermission->setPermission($this);
        }

        return $this;
    }

    public function removeUiPermission(SubscriptionUiPermission $uiPermission): self
    {
        if ($this->uiPermissions->removeElement($uiPermission)) {
            // set the owning side to null (unless already changed)
            if ($uiPermission->getPermission() === $this) {
                $uiPermission->setPermission(null);
            }
        }

        return $this;
    }
}
