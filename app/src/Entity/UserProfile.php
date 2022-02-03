<?php

namespace App\Entity;

use App\Repository\UserProfileRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
class UserProfile
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var User|null
     */
    #[ORM\OneToOne(inversedBy: 'userProfile', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'common@userIsRequired', payload: 'user_is_required')]
    private ?User $user = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 50, options: [
        'comment' => 'User real name'
    ])]
    #[Assert\NotBlank(message: 'userProfile@nameIsRequired', payload: 'name_is_required')]
    #[Assert\Length(max: 50, maxMessage: 'userProfile@nameMaxLength', payload: 'name_length')]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 50, nullable: true, options: [
        'comment' => 'User real surname'
    ])]
    #[Assert\Length(max: 50, maxMessage: 'user@surnameMaxLength', payload: 'surname_length')]
    private ?string $surname = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 50, nullable: true, options: [
        'comment' => 'User real patronymic'
    ])]
    #[Assert\Length(max: 50, maxMessage: 'user@patronymicMaxLength', payload: 'patronymic_length')]
    private ?string $patronymic = null;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: 'date', options: [
        'comment' => 'User date of birth'
    ])]
    #[Assert\Date(message: 'userProfile@invalidBirth')]
    private ?DateTimeInterface $birth = null;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $updatedAt;

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

    public function __construct()
    {

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

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
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {

        return $this->createdAt;

    }

    /**
     * @return $this
     */
    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {

        $this->createdAt = new DateTimeImmutable();

        return $this;

    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getUpdatedAt(): ?DateTimeImmutable
    {

        return $this->updatedAt;

    }

    /**
     * @param DateTimeImmutable $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {

        $this->updatedAt = $updatedAt;

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
