<?php

namespace App\Entity;

use App\DBAL\Types\PasswordType;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\ResponseTypeEnum;
use App\Enum\UserStatusEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('email', message: 'user@existByEmail', payload: [ResponseTypeEnum::EXIST, 409])]
class User implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'Email to login'
    ])]
    private ?string $email = null;

    #[ORM\Column(type: PasswordType::NAME, options: [
        'comment' => 'Password as secure hash'
    ])]
    private ?string $password = null;

    #[ORM\ManyToOne(targetEntity: Role::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'One of the UserStatusEnum statuses'
    ])]
    private ?string $status = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: UserProfile::class, cascade: ['persist', 'remove'])]
    private ?UserProfile $profile = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserSession::class)]
    private Collection $sessions;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: AccountActivationCode::class, cascade: ['persist', 'remove'])]
    private ?AccountActivationCode $accountActivationCode = null;

    #[Pure]
    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
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
     * @return null|Role
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * @param null|Role $role
     *
     * @return $this
     */
    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @param UserStatusEnum $userStatusEnum
     *
     * @return bool
     */
    #[Pure]
    public function isStatus(UserStatusEnum $userStatusEnum): bool
    {
        return $this->getStatus() === $userStatusEnum->name;
    }

    /**
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param null|UserStatusEnum $status
     *
     * @return $this
     */
    public function setStatus(?UserStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }

    /**
     * @return null|UserProfile
     */
    public function getProfile(): ?UserProfile
    {
        return $this->profile;
    }

    /**
     * @param UserProfile $profile
     *
     * @return $this
     */
    public function setProfile(UserProfile $profile): self
    {
        // set the owning side of the relation if necessary
        if ($profile->getUser() !== $this) {
            $profile->setUser($this);
        }

        $this->profile = $profile;

        return $this;
    }

    /**
     * @return Collection<int, UserSession>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    /**
     * @param UserSession $session
     *
     * @return $this
     */
    public function addSession(UserSession $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setUser($this);
        }

        return $this;
    }

    /**
     * @param UserSession $session
     *
     * @return $this
     */
    public function removeSession(UserSession $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getUser() === $this) {
                $session->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return null|AccountActivationCode
     */
    public function getAccountActivationCode(): ?AccountActivationCode
    {
        return $this->accountActivationCode;
    }

    /**
     * @param AccountActivationCode $accountActivationCode
     *
     * @return $this
     */
    public function setAccountActivationCode(AccountActivationCode $accountActivationCode): self
    {
        // set the owning side of the relation if necessary
        if ($accountActivationCode->getUser() !== $this) {
            $accountActivationCode->setUser($this);
        }

        $this->accountActivationCode = $accountActivationCode;

        return $this;
    }
}
