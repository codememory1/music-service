<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\UserProfileStatusEnum;
use App\Repository\UserProfileRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class UserProfile.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserProfileRepository::class)]
#[ORM\Table('user_profiles')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('user', message: 'userProfile@existByUser')]
class UserProfile implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\OneToOne(inversedBy: 'profile', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::STRING, length: 40, options: [
        'comment' => 'Account pseudonym'
    ])]
    private ?string $pseudonym = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'User date of birth'
    ])]
    private ?DateTimeImmutable $dateBirth = null;

    #[ORM\Column(type: Types::STRING, nullable: true, options: [
        'comment' => 'Photo as path s3 storage'
    ])]
    private ?string $photo = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'One of the UserProfileStatusEnum statuses'
    ])]
    private ?string $status = null;

    #[ORM\OneToOne(mappedBy: 'userProfile', targetEntity: UserProfileDesign::class, cascade: ['persist', 'remove'])]
    private $design;

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getPseudonym(): ?string
    {
        return $this->pseudonym;
    }

    public function setPseudonym(?string $pseudonym): self
    {
        $this->pseudonym = $pseudonym;

        return $this;
    }

    public function getDateBirth(): ?DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(?DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?UserProfileStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }

    public function setHideStatus(): self
    {
        $this->setStatus(UserProfileStatusEnum::HIDE);

        return $this;
    }

    #[Pure]
    public function isHide(): bool
    {
        return $this->getStatus() === UserProfileStatusEnum::HIDE->name;
    }

    public function setShowStatus(): self
    {
        $this->setStatus(UserProfileStatusEnum::SHOW);

        return $this;
    }

    #[Pure]
    public function isShow(): bool
    {
        return $this->getStatus() === UserProfileStatusEnum::SHOW->name;
    }

    public function getDesign(): ?UserProfileDesign
    {
        return $this->design;
    }

    public function setDesign(UserProfileDesign $design): self
    {
        // set the owning side of the relation if necessary
        if ($design->getUserProfile() !== $this) {
            $design->setUserProfile($this);
        }

        $this->design = $design;

        return $this;
    }
}
