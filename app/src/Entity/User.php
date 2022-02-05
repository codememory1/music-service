<?php

namespace App\Entity;

use App\Enums\ApiResponseTypeEnum;
use App\Enums\StatusEnum;
use App\Repository\UserRepository;
use App\ValidatorConstraints as AppAssert;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table('users')]
#[UniqueEntity('email', 'user@emailExist', payload: [ApiResponseTypeEnum::CHECK_EXIST, 'email_exist'])]
#[UniqueEntity('username', 'user@usernameExist', payload: [ApiResponseTypeEnum::CHECK_EXIST, 'username_exist'])]
#[ORM\HasLifecycleCallbacks]
class User
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, unique: true, options: [
        'comment' => 'User unique mail'
    ])]
    #[Assert\Email(message: 'common@invalidEmail', payload: 'invalid_email')]
    #[Assert\Length(max: 255, maxMessage: 'common@emailMaxLength', payload: 'email_length')]
    private ?string $email = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 250, unique: true, options: [
        'comment' => 'The default username is the truncated mail then the symbol @'
    ])]
    #[Assert\NotBlank(message: 'user@usernameIsRequired', payload: 'username_is_required')]
    #[Assert\Length(max: 250, maxMessage: 'user@usernameMaxLength', payload: 'username_length')]
    private ?string $username = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text', options: [
        'comment' => 'User password hash'
    ])]
    #[Assert\NotBlank(message: 'user@passwordIsRequired', payload: 'password_is_required')]
    #[Assert\Length(min: 8, minMessage: 'user@passwordMinLength', payload: 'password_length')]
    #[Assert\Regex('/^[a-z0-9\-_%\.\$\#]+$/i', message: 'user@passwordRegex', payload: 'password_regexp')]
    private ?string $password = null;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'user@passwordConfirmIsRequired', payload: 'password_confirm_is_required')]
    #[AppAssert\Between('getPassword', 'user@invalidPasswordConfirm', 'password_confirm_is_invalid')]
    private ?string $passwordConfirm = null;

    /**
     * @var Role|null
     */
    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'user@roleIsRequired', payload: 'role_is_required')]
    private ?Role $role;

    /**
     * @var int|null
     */
    #[ORM\Column(type: 'smallint', options: [
        'comment' => 'User status, not active by default'
    ])]
    #[Assert\NotBlank(message: 'common@statusIsRequired', payload: 'status_is_required')]
    #[Assert\Choice(callback: [
        StatusEnum::class, 'values'
    ], message: 'common@invalidStatus', payload: 'status_invalid')]
    private ?int $status;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt = null;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $updatedAt;

    /**
     * @var UserProfile|null
     */
    #[ORM\OneToOne(mappedBy: 'user', targetEntity: UserProfile::class, cascade: ['persist', 'remove'])]
    private ?UserProfile $userProfile = null;

    /**
     * @var UserSubscription|null
     */
    #[ORM\OneToOne(mappedBy: 'user', targetEntity: UserSubscription::class, cascade: ['persist', 'remove'])]
    private ?UserSubscription $userSubscription = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserSession::class)]
    private Collection $userSessions;

    /**
     * @var UserActivationToken|null
     */
    #[ORM\OneToOne(mappedBy: 'user', targetEntity: UserActivationToken::class, cascade: ['persist', 'remove'])]
    private ?UserActivationToken $userActivationToken = null;

    public function __construct()
    {

        $this->status = StatusEnum::NOT_ACTIVE->value;
        $this->updatedAt = new DateTimeImmutable();
        $this->userSessions = new ArrayCollection();

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {

        return $this->email;

    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {

        $this->email = $email;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {

        return $this->username;

    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): self
    {

        $this->username = $username;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {

        return $this->password;

    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {

        $this->password = $password;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getPasswordConfirm(): ?string
    {

        return $this->passwordConfirm;

    }

    /**
     * @param string|null $passwordConfirm
     *
     * @return $this
     */
    public function setPasswordConfirm(?string $passwordConfirm): self
    {

        $this->passwordConfirm = $passwordConfirm;

        return $this;

    }

    /**
     * @return Role|null
     */
    public function getRole(): ?Role
    {

        return $this->role;

    }

    /**
     * @param Role|null $role
     *
     * @return $this
     */
    public function setRole(?Role $role): self
    {

        $this->role = $role;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {

        return $this->status;

    }

    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus(int $status): self
    {

        $this->status = $status;

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
     * @return UserProfile|null
     */
    public function getUserProfile(): ?UserProfile
    {

        return $this->userProfile;

    }

    /**
     * @param UserProfile $userProfile
     *
     * @return $this
     */
    public function setUserProfile(UserProfile $userProfile): self
    {

        // set the owning side of the relation if necessary
        if ($userProfile->getUser() !== $this) {
            $userProfile->setUser($this);
        }

        $this->userProfile = $userProfile;

        return $this;

    }

    /**
     * @return UserSubscription|null
     */
    public function getUserSubscription(): ?UserSubscription
    {

        return $this->userSubscription;

    }

    /**
     * @param UserSubscription $userSubscription
     *
     * @return $this
     */
    public function setUserSubscription(UserSubscription $userSubscription): self
    {

        // set the owning side of the relation if necessary
        if ($userSubscription->getUser() !== $this) {
            $userSubscription->setUser($this);
        }

        $this->userSubscription = $userSubscription;

        return $this;

    }

    /**
     * @return Collection
     */
    public function getUserSessions(): Collection
    {

        return $this->userSessions;

    }

    /**
     * @param UserSession $userSession
     *
     * @return $this
     */
    public function addUserSession(UserSession $userSession): self
    {

        if (!$this->userSessions->contains($userSession)) {
            $this->userSessions[] = $userSession;
            $userSession->setUser($this);
        }

        return $this;

    }

    /**
     * @param UserSession $userSession
     *
     * @return $this
     */
    public function removeUserSession(UserSession $userSession): self
    {

        if ($this->userSessions->removeElement($userSession)) {
            // set the owning side to null (unless already changed)
            if ($userSession->getUser() === $this) {
                $userSession->setUser(null);
            }
        }

        return $this;

    }

    /**
     * @return UserActivationToken|null
     */
    public function getUserActivationToken(): ?UserActivationToken
    {

        return $this->userActivationToken;

    }

    /**
     * @param UserActivationToken $userActivationToken
     *
     * @return $this
     */
    public function setUserActivationToken(UserActivationToken $userActivationToken): self
    {

        // set the owning side of the relation if necessary
        if ($userActivationToken->getUser() !== $this) {
            $userActivationToken->setUser($this);
        }

        $this->userActivationToken = $userActivationToken;

        return $this;

    }

}
