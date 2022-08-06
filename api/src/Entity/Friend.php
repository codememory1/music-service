<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\FriendStatusEnum;
use App\Repository\FriendRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class Friend.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: FriendRepository::class)]
#[ORM\Table('friends')]
#[ORM\HasLifecycleCallbacks]
class Friend implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'friendRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'acceptedFriendRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $friend = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Status from FriendStatusEnum'
    ])]
    private ?string $status = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFriend(): ?User
    {
        return $this->friend;
    }

    public function setFriend(?User $friend): self
    {
        $this->friend = $friend;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?FriendStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }

    public function setAwaitingConfirmation(): self
    {
        return $this->setStatus(FriendStatusEnum::AWAITING_CONFIRMATION);
    }

    #[Pure]
    public function isAwaitingConfirmation(): bool
    {
        return $this->getStatus() === FriendStatusEnum::AWAITING_CONFIRMATION->name;
    }

    public function setConfirmed(): self
    {
        return $this->setStatus(FriendStatusEnum::CONFIRMED);
    }

    #[Pure]
    public function isConfirmed(): bool
    {
        return $this->getStatus() === FriendStatusEnum::CONFIRMED->name;
    }
}
