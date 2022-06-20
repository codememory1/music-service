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

    #[ORM\Column(type: PasswordType::NAME, nullable: true, options: [
        'comment' => 'Password as secure hash'
    ])]
    private ?string $password = null;

    #[ORM\ManyToOne(targetEntity: Role::class, cascade: ['persist'])]
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

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: AccountActivationCode::class, cascade: ['persist', 'remove'])]
    private Collection $accountActivationCodes;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PasswordReset::class, cascade: ['persist', 'remove'])]
    private Collection $passwordResets;

    #[ORM\ManyToOne(targetEntity: Subscription::class)]
    private ?Subscription $subscription = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Album::class, cascade: ['remove'])]
    private Collection $albums;

    #[ORM\OneToMany(mappedBy: 'toUser', targetEntity: UserNotification::class, cascade: ['persist', 'remove'])]
    private Collection $notifications;

    #[ORM\Column(type: Types::STRING, length: 500, nullable: true, options: [
        'comment' => 'Unique id of your profile in the authorization service'
    ])]
    private ?string $idInAuthService = null;

    #[ORM\Column(type: Types::STRING, length: 25, nullable: true, options: [
        'comment' => 'The type of service in which authorization occurred'
    ])]
    private ?string $authServiceType = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Multimedia::class)]
    private Collection $multimedia;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MultimediaPerformer::class)]
    private Collection $multimediaPerformers;

    #[Pure]
    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->accountActivationCodes = new ArrayCollection();
        $this->passwordResets = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->multimedia = new ArrayCollection();
        $this->multimediaPerformers = new ArrayCollection();
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
     * @return Collection<AccountActivationCode>
     */
    public function getAccountActivationCode(): Collection
    {
        return $this->accountActivationCodes;
    }

    /**
     * @param AccountActivationCode $accountActivationCode
     *
     * @return $this
     */
    public function setAccountActivationCode(AccountActivationCode $accountActivationCode): self
    {
        if (!$this->accountActivationCodes->contains($accountActivationCode)) {
            $this->accountActivationCodes[] = $accountActivationCode;
            $accountActivationCode->setUser($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPasswordResets(): Collection
    {
        return $this->passwordResets;
    }

    /**
     * @param PasswordReset $passwordReset
     *
     * @return $this
     */
    public function setPasswordReset(PasswordReset $passwordReset): self
    {
        if (!$this->passwordResets->contains($passwordReset)) {
            $this->passwordResets[] = $passwordReset;
            $passwordReset->setUser($this);
        }

        return $this;
    }

    /**
     * @return null|Subscription
     */
    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    /**
     * @param null|Subscription $subscription
     *
     * @return $this
     */
    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * @param Album $album
     *
     * @return $this
     */
    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setUser($this);
        }

        return $this;
    }

    /**
     * @param Album $album
     *
     * @return $this
     */
    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getUser() === $this) {
                $album->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserNotification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    /**
     * @param Notification $notification
     *
     * @return $this
     */
    public function addNotification(Notification $notification): self
    {
        $userNotification = new UserNotification();

        $userNotification->setTo($this);
        $userNotification->setNotification($notification);

        if (!$this->notifications->contains($userNotification)) {
            $this->notifications[] = $userNotification;
        }

        return $this;
    }

    /**
     * @param UserNotification $notification
     *
     * @return $this
     */
    public function removeNotification(UserNotification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getTo() === $this) {
                $notification->setTo(null);
            }
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getIdInAuthService(): ?string
    {
        return $this->idInAuthService;
    }

    /**
     * @param null|string $idInAuthService
     *
     * @return $this
     */
    public function setIdInAuthService(?string $idInAuthService): self
    {
        $this->idInAuthService = $idInAuthService;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAuthServiceType(): ?string
    {
        return $this->authServiceType;
    }

    /**
     * @param null|string $authServiceType
     *
     * @return $this
     */
    public function setAuthServiceType(?string $authServiceType): self
    {
        $this->authServiceType = $authServiceType;

        return $this;
    }

    /**
     * @return Collection<int, Multimedia>
     */
    public function getMultimedia(): Collection
    {
        return $this->multimedia;
    }

    /**
     * @param Multimedia $multimedia
     *
     * @return $this
     */
    public function addMultimedia(Multimedia $multimedia): self
    {
        if (!$this->multimedia->contains($multimedia)) {
            $this->multimedia[] = $multimedia;
            $multimedia->setUser($this);
        }

        return $this;
    }

    /**
     * @param Multimedia $multimedia
     *
     * @return $this
     */
    public function removeMultimedia(Multimedia $multimedia): self
    {
        if ($this->multimedia->removeElement($multimedia)) {
            // set the owning side to null (unless already changed)
            if ($multimedia->getUser() === $this) {
                $multimedia->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MultimediaPerformer>
     */
    public function getMultimediaPerformers(): Collection
    {
        return $this->multimediaPerformers;
    }

    /**
     * @param MultimediaPerformer $multimediaPerformer
     *
     * @return $this
     */
    public function addMultimediaPerformer(MultimediaPerformer $multimediaPerformer): self
    {
        if (!$this->multimediaPerformers->contains($multimediaPerformer)) {
            $this->multimediaPerformers[] = $multimediaPerformer;
            $multimediaPerformer->setUser($this);
        }

        return $this;
    }

    /**
     * @param MultimediaPerformer $multimediaPerformer
     *
     * @return $this
     */
    public function removeMultimediaPerformer(MultimediaPerformer $multimediaPerformer): self
    {
        if ($this->multimediaPerformers->removeElement($multimediaPerformer)) {
            // set the owning side to null (unless already changed)
            if ($multimediaPerformer->getUser() === $this) {
                $multimediaPerformer->setUser(null);
            }
        }

        return $this;
    }
}
