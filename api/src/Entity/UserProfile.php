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

    #[ORM\OneToOne(targetEntity: User::class)]
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

    /**
     * @param null|User $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return null|string
     */
    public function getPseudonym(): ?string
    {
        return $this->pseudonym;
    }

    /**
     * @param null|string $pseudonym
     *
     * @return $this
     */
    public function setPseudonym(?string $pseudonym): self
    {
        $this->pseudonym = $pseudonym;

        return $this;
    }

    /**
     * @return null|DateTimeInterface
     */
    public function getDateBirth(): ?DateTimeInterface
    {
        return $this->dateBirth;
    }

    /**
     * @param null|DateTimeInterface $dateBirth
     *
     * @return $this
     */
    public function setDateBirth(?DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param null|string $photo
     *
     * @return $this
     */
    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

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
     * @param null|UserProfileStatusEnum $status
     *
     * @return $this
     */
    public function setStatus(?UserProfileStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }
}
