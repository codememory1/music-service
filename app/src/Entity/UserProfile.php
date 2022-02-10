<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\UserProfileRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserProfile
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
     * @var User|null
     */
    #[ORM\OneToOne(inversedBy: 'userProfile', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 50, options: [
        'comment' => 'User real name'
    ])]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 50, nullable: true, options: [
        'comment' => 'User real surname'
    ])]
    private ?string $surname = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 50, nullable: true, options: [
        'comment' => 'User real patronymic'
    ])]
    private ?string $patronymic = null;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: 'date', options: [
        'comment' => 'User date of birth'
    ])]
    private ?DateTimeInterface $birth = null;

    /**
     * @var UserProfileCover|null
     */
    #[ORM\OneToOne(mappedBy: 'userProfile', targetEntity: UserProfileCover::class, cascade: ['persist', 'remove'])]
    private ?UserProfileCover $userProfileCover = null;

    /**
     * @var UserProfilePhoto|null
     */
    #[ORM\OneToOne(mappedBy: 'userProfile', targetEntity: UserProfilePhoto::class, cascade: ['persist', 'remove'])]
    private ?UserProfilePhoto $userProfilePhoto;

    /**
     * @return User|null
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
     * @return string|null
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
     * @return string|null
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
     * @return string|null
     */
    public function getPatronymic(): ?string
    {

        return $this->patronymic;

    }

    /**
     * @param string|null $patronymic
     *
     * @return $this
     */
    public function setPatronymic(?string $patronymic): self
    {

        $this->patronymic = $patronymic;

        return $this;

    }

    /**
     * @return DateTimeInterface|null
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
     * @return UserProfileCover|null
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
     * @return UserProfilePhoto|null
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

}
