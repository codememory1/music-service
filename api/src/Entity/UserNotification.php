<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\UserNotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserNotificationRepository::class)]
#[ORM\Table('user_notifications')]
#[ORM\HasLifecycleCallbacks]
class UserNotification implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'notifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $toUser = null;

    #[ORM\ManyToOne(targetEntity: Notification::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Notification $notification = null;

    public function getTo(): ?User
    {
        return $this->toUser;
    }

    public function setTo(?User $toUser): self
    {
        $this->toUser = $toUser;

        return $this;
    }

    public function getNotification(): ?Notification
    {
        return $this->notification;
    }

    public function setNotification(?Notification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }
}
