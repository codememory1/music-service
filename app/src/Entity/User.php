<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Enum\StatusEnum;
use App\Interface\EntityInterface;
use App\Repository\UserRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table('users')]
#[UniqueEntity(
    'email',
    'user@emailExist',
    payload: [ApiResponseTypeEnum::CHECK_EXIST, 'email_exist']
)]
#[UniqueEntity(
    'username',
    'user@usernameExist',
    payload: [ApiResponseTypeEnum::CHECK_EXIST, 'username_exist']
)]
#[ORM\HasLifecycleCallbacks]
class User implements EntityInterface
{

    use IdentifierTrait;
    use TimestampTrait;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, unique: true, options: [
        'comment' => 'User unique mail'
    ])]
    private ?string $email = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 250, unique: true, options: [
        'comment' => 'The default username is the truncated mail then the symbol @'
    ])]
    private ?string $username = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text', options: [
        'comment' => 'User password hash'
    ])]
    private ?string $password = null;

    /**
     * @var Role|null
     */
    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role;

    /**
     * @var int|null
     */
    #[ORM\Column(type: 'smallint', options: [
        'comment' => 'User status, not active by default'
    ])]
    private ?int $status;

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

    #[Pure]
    public function __construct()
    {

        $this->status = StatusEnum::NOT_ACTIVE->value;
        $this->userSessions = new ArrayCollection();

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
