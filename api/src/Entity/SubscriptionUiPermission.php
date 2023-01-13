<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\SubscriptionUiPermissionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionUiPermissionRepository::class)]
#[ORM\Table('subscription_ui_permissions')]
#[ORM\HasLifecycleCallbacks]
class SubscriptionUiPermission implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Subscription::class, inversedBy: 'uiPermissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscription $subscription = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Permission name as a translation key'
    ])]
    private ?string $titleTranslationKey = null;

    #[ORM\ManyToOne(targetEntity: SubscriptionPermission::class, inversedBy: 'uiPermissions')]
    #[ORM\JoinColumn(nullable: true)]
    private ?SubscriptionPermission $permission = null;

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->titleTranslationKey;
    }

    public function setTitle(string $title): self
    {
        $this->titleTranslationKey = $title;

        return $this;
    }

    public function getPermission(): ?SubscriptionPermission
    {
        return $this->permission;
    }

    public function setPermission(?SubscriptionPermission $permission): self
    {
        $this->permission = $permission;

        return $this;
    }
}
