<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\UserSettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSettingRepository::class)]
#[ORM\Table('user_settings')]
#[ORM\HasLifecycleCallbacks]
class UserSetting implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\OneToOne(inversedBy: 'setting', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        'comment' => ''
    ])]
    private ?bool $acceptMultimediaFromFriends = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isAcceptMultimediaFromFriends(): ?bool
    {
        return $this->acceptMultimediaFromFriends;
    }

    public function setAcceptMultimediaFromFriends(?bool $acceptMultimediaFromFriends): self
    {
        $this->acceptMultimediaFromFriends = $acceptMultimediaFromFriends;

        return $this;
    }
}
