<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\UserProfileRepository;
use App\Traits\Entity\IdentifierTrait;
use App\Traits\Entity\TimestampTrait;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
class UserProfile implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|User
     */
    #[ORM\OneToOne(inversedBy: 'userProfile', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 50, options: [
        'comment' => 'User real name'
    ])]
    private ?string $name = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 50, nullable: true, options: [
        'comment' => 'User real surname'
    ])]
    private ?string $surname = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 50, nullable: true, options: [
        'comment' => 'User real patronymic'
    ])]
    private ?string $patronymic = null;

    /**
     * @var null|DateTimeInterface
     */
    #[ORM\Column(type: Types::DATE_MUTABLE, options: [
        'comment' => 'User date of birth'
    ])]
    private ?DateTimeInterface $birth = null;

    /**
     * @var null|UserProfileCover
     */
    #[ORM\OneToOne(mappedBy: 'userProfile', targetEntity: UserProfileCover::class, cascade: ['persist', 'remove'])]
    private ?UserProfileCover $userProfileCover = null;

    /**
     * @var null|UserProfilePhoto
     */
    #[ORM\OneToOne(mappedBy: 'userProfile', targetEntity: UserProfilePhoto::class, cascade: ['persist', 'remove'])]
    private ?UserProfilePhoto $userProfilePhoto;

    /**
     * @var null|UserProfileDesign
     */
    #[ORM\OneToOne(mappedBy: 'userProfile', targetEntity: UserProfileDesign::class, cascade: ['persist', 'remove'])]
    private ?UserProfileDesign $userProfileDesign = null;

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     *
     * @return $this
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    /**
     * @param null|string $patronymic
     *
     * @return $this
     */
    public function setPatronymic(?string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    /**
     * @return null|DateTimeInterface
     */
    public function getBirth(): ?DateTimeInterface
    {
        return $this->birth;
    }

    /**
     * @param DateTimeInterface $birth
     *
     * @return $this
     */
    public function setBirth(DateTimeInterface $birth): self
    {
        $this->birth = $birth;

        return $this;
    }

    /**
     * @return null|UserProfileCover
     */
    public function getUserProfileCover(): ?UserProfileCover
    {
        return $this->userProfileCover;
    }

    /**
     * @param UserProfileCover $userProfileCover
     *
     * @return $this
     */
    public function setUserProfileCover(UserProfileCover $userProfileCover): self
    {
        // set the owning side of the relation if necessary
        if ($userProfileCover->getUserProfile() !== $this) {
            $userProfileCover->setUserProfile($this);
        }

        $this->userProfileCover = $userProfileCover;

        return $this;
    }

    /**
     * @return null|UserProfilePhoto
     */
    public function getUserProfilePhoto(): ?UserProfilePhoto
    {
        return $this->userProfilePhoto;
    }

    /**
     * @param UserProfilePhoto $userProfilePhoto
     *
     * @return $this
     */
    public function setUserProfilePhoto(UserProfilePhoto $userProfilePhoto): self
    {
        // set the owning side of the relation if necessary
        if ($userProfilePhoto->getUserProfile() !== $this) {
            $userProfilePhoto->setUserProfile($this);
        }

        $this->userProfilePhoto = $userProfilePhoto;

        return $this;
    }

    /**
     * @return null|UserProfileDesign
     */
    public function getUserProfileDesign(): ?UserProfileDesign
    {
        return $this->userProfileDesign;
    }

    /**
     * @param UserProfileDesign $userProfileDesign
     *
     * @return $this
     */
    public function setUserProfileDesign(UserProfileDesign $userProfileDesign): self
    {
        // set the owning side of the relation if necessary
        if ($userProfileDesign->getUserProfile() !== $this) {
            $userProfileDesign->setUserProfile($this);
        }

        $this->userProfileDesign = $userProfileDesign;

        return $this;
    }
}
