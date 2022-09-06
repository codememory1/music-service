<?php

namespace App\Entity;

use App\DBAL\Types\PasswordType;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\FriendStatusEnum;
use App\Enum\ResponseTypeEnum;
use App\Enum\RoleEnum;
use App\Enum\RolePermissionEnum;
use App\Enum\SubscriptionEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Enum\UserStatusEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('email', message: 'user@existByEmail', payload: [ResponseTypeEnum::EXIST, 409])]
class User implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

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

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserSession::class, cascade: ['persist', 'remove'])]
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

    #[ORM\OneToMany(mappedBy: 'fromUser', targetEntity: MultimediaShare::class)]
    private Collection $multimediaSharedByMe;

    #[ORM\OneToMany(mappedBy: 'toUser', targetEntity: MultimediaShare::class)]
    private Collection $multimediaSharedWithMe;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MultimediaAudition::class)]
    private Collection $multimediaAuditions;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MultimediaRating::class)]
    private Collection $multimediaRatings;

    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: ArtistSubscriber::class, cascade: ['persist', 'remove'])]
    private Collection $subscribers;

    #[ORM\OneToMany(mappedBy: 'subscriber', targetEntity: ArtistSubscriber::class, cascade: ['persist', 'remove'])]
    private Collection $subscriptions;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: MediaLibrary::class, cascade: ['persist', 'remove'])]
    private ?MediaLibrary $mediaLibrary = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Friend::class, cascade: ['persist', 'remove'])]
    private Collection $friendRequests;

    #[ORM\OneToMany(mappedBy: 'friend', targetEntity: Friend::class, cascade: ['persist', 'remove'])]
    private Collection $acceptedFriendRequests;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: UserSetting::class, cascade: ['persist', 'remove'])]
    private ?UserSetting $setting = null;

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
        $this->multimediaSharedByMe = new ArrayCollection();
        $this->multimediaSharedWithMe = new ArrayCollection();
        $this->multimediaAuditions = new ArrayCollection();
        $this->multimediaRatings = new ArrayCollection();
        $this->subscribers = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->friendRequests = new ArrayCollection();
        $this->acceptedFriendRequests = new ArrayCollection();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setActiveStatus(): self
    {
        $this->setStatus(UserStatusEnum::ACTIVE);

        return $this;
    }

    #[Pure]
    public function isActive(): bool
    {
        return $this->getStatus() === UserStatusEnum::ACTIVE->name;
    }

    public function setNotActiveStatus(): self
    {
        $this->setStatus(UserStatusEnum::NOT_ACTIVE);

        return $this;
    }

    #[Pure]
    public function isNotActive(): bool
    {
        return $this->getStatus() === UserStatusEnum::NOT_ACTIVE->name;
    }

    public function setStatus(?UserStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }

    public function getProfile(): ?UserProfile
    {
        return $this->profile;
    }

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

    public function addSession(UserSession $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setUser($this);
        }

        return $this;
    }

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
     * @return Collection<int, AccountActivationCode>
     */
    public function getAccountActivationCode(): Collection
    {
        return $this->accountActivationCodes;
    }

    public function getLastAccountActivationCode(): ?int
    {
        $lastAccountActivationCode = $this->getAccountActivationCode()->last();

        if (false === $lastAccountActivationCode) {
            return null;
        }

        return $lastAccountActivationCode->getCode();
    }

    public function setAccountActivationCode(AccountActivationCode $accountActivationCode): self
    {
        if (!$this->accountActivationCodes->contains($accountActivationCode)) {
            $this->accountActivationCodes[] = $accountActivationCode;
            $accountActivationCode->setUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PasswordReset>
     */
    public function getPasswordResets(): Collection
    {
        return $this->passwordResets;
    }

    public function getLastPasswordResetCode(): ?int
    {
        $lastPasswordReset = $this->getPasswordResets()->last();

        if (false === $lastPasswordReset) {
            return null;
        }

        return $lastPasswordReset->getCode();
    }

    public function setPasswordReset(PasswordReset $passwordReset): self
    {
        if (!$this->passwordResets->contains($passwordReset)) {
            $this->passwordResets[] = $passwordReset;
            $passwordReset->setUser($this);
        }

        return $this;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setUser($this);
        }

        return $this;
    }

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

    public function getIdInAuthService(): ?string
    {
        return $this->idInAuthService;
    }

    public function setIdInAuthService(?string $idInAuthService): self
    {
        $this->idInAuthService = $idInAuthService;

        return $this;
    }

    public function getAuthServiceType(): ?string
    {
        return $this->authServiceType;
    }

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

    public function addMultimedia(Multimedia $multimedia): self
    {
        if (!$this->multimedia->contains($multimedia)) {
            $this->multimedia[] = $multimedia;
            $multimedia->setUser($this);
        }

        return $this;
    }

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

    public function addMultimediaPerformer(MultimediaPerformer $multimediaPerformer): self
    {
        if (!$this->multimediaPerformers->contains($multimediaPerformer)) {
            $this->multimediaPerformers[] = $multimediaPerformer;
            $multimediaPerformer->setUser($this);
        }

        return $this;
    }

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

    /**
     * @return Collection<int, MultimediaShare>
     */
    public function getMultimediaSharedByMe(): Collection
    {
        return $this->multimediaSharedByMe;
    }

    public function removeMultimediaSharedByMe(MultimediaShare $sharedByMe): self
    {
        if ($this->multimediaSharedByMe->removeElement($sharedByMe)) {
            // set the owning side to null (unless already changed)
            if ($sharedByMe->getToUser() === $this) {
                $sharedByMe->setToUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MultimediaShare>
     */
    public function getMultimediaSharedWithMe(): Collection
    {
        return $this->multimediaSharedWithMe;
    }

    public function removeSharedWithMe(MultimediaShare $sharedWithMe): self
    {
        if ($this->multimediaSharedWithMe->removeElement($sharedWithMe)) {
            // set the owning side to null (unless already changed)
            if ($sharedWithMe->getToUser() === $this) {
                $sharedWithMe->setToUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MultimediaAudition>
     */
    public function getMultimediaAuditions(): Collection
    {
        return $this->multimediaAuditions;
    }

    public function addMultimediaAudition(MultimediaAudition $multimediaAudition): self
    {
        if (!$this->multimediaAuditions->contains($multimediaAudition)) {
            $this->multimediaAuditions[] = $multimediaAudition;
            $multimediaAudition->setUser($this);
        }

        return $this;
    }

    public function removeMultimediaAudition(MultimediaAudition $multimediaAudition): self
    {
        if ($this->multimediaAuditions->removeElement($multimediaAudition)) {
            // set the owning side to null (unless already changed)
            if ($multimediaAudition->getUser() === $this) {
                $multimediaAudition->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MultimediaRating>
     */
    public function getMultimediaRatings(): Collection
    {
        return $this->multimediaRatings;
    }

    public function addMultimediaRating(MultimediaRating $multimediaRating): self
    {
        if (!$this->multimediaRatings->contains($multimediaRating)) {
            $this->multimediaRatings[] = $multimediaRating;
            $multimediaRating->setUser($this);
        }

        return $this;
    }

    public function removeMultimediaRating(MultimediaRating $multimediaRating): self
    {
        if ($this->multimediaRatings->removeElement($multimediaRating)) {
            // set the owning side to null (unless already changed)
            if ($multimediaRating->getUser() === $this) {
                $multimediaRating->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ArtistSubscriber>
     */
    public function getSubscribers(): Collection
    {
        return $this->subscribers;
    }

    public function addSubscriber(ArtistSubscriber $subscriber): self
    {
        if (!$this->subscribers->contains($subscriber)) {
            $this->subscribers[] = $subscriber;
            $subscriber->setArtist($this);
        }

        return $this;
    }

    public function removeSubscriber(ArtistSubscriber $subscriber): self
    {
        if ($this->subscribers->removeElement($subscriber)) {
            // set the owning side to null (unless already changed)
            if ($subscriber->getArtist() === $this) {
                $subscriber->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ArtistSubscriber>
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(ArtistSubscriber $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
            $subscription->setSubscriber($this);
        }

        return $this;
    }

    public function removeSubscription(ArtistSubscriber $subscription): self
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getSubscriber() === $this) {
                $subscription->setSubscriber(null);
            }
        }

        return $this;
    }

    public function getMediaLibrary(): ?MediaLibrary
    {
        return $this->mediaLibrary;
    }

    public function setMediaLibrary(MediaLibrary $mediaLibrary): self
    {
        // set the owning side of the relation if necessary
        if ($mediaLibrary->getUser() !== $this) {
            $mediaLibrary->setUser($this);
        }

        $this->mediaLibrary = $mediaLibrary;

        return $this;
    }

    /**
     * @return Collection<int, Friend>
     */
    public function getFriends(): Collection
    {
        return new ArrayCollection(array_merge(
            $this->friendRequests->toArray(),
            $this->acceptedFriendRequests->toArray()
        ));
    }

    public function addFriend(Friend $friend): self
    {
        if (!$this->friendRequests->contains($friend)) {
            $this->friendRequests[] = $friend;
            $friend->setUser($this);
        }

        return $this;
    }

    public function removeFriend(Friend $friend): self
    {
        if ($this->friendRequests->removeElement($friend)) {
            // set the owning side to null (unless already changed)
            if ($friend->getUser() === $this) {
                $friend->setUser(null);
            }
        }

        return $this;
    }

    public function isFriend(self $user): bool
    {
        $criteria = Criteria::create();

        $criteria->orWhere(Criteria::expr()->eq('user', $user));
        $criteria->orWhere(Criteria::expr()->eq('friend', $user));
        $criteria->andWhere(Criteria::expr()->eq('status', FriendStatusEnum::CONFIRMED->name));

        return 1 === $this->getFriends()->matching($criteria)->count();
    }

    public function getSetting(): ?UserSetting
    {
        return $this->setting;
    }

    public function setSetting(UserSetting $setting): self
    {
        // set the owning side of the relation if necessary
        if ($setting->getUser() !== $this) {
            $setting->setUser($this);
        }

        $this->setting = $setting;

        return $this;
    }

    #[Pure]
    public function isRole(RoleEnum $role): bool
    {
        return $this->getRole()->getKey() === $role->name;
    }

    public function isRolePermission(RolePermissionEnum $expectedRolePermission): bool
    {
        return $this
            ->getRole()
            ->getPermissions()
            ->exists(static fn(int $key, RolePermission $rolePermission): bool => $rolePermission->getPermissionKey()->getKey() === $expectedRolePermission->name);
    }

    public function isSubscriptionPermission(SubscriptionPermissionEnum $expectedSubscriptionPermission): bool
    {
        if (null === $subscriptionPermissions = $this->getSubscription()?->getPermissions()) {
            return false;
        }

        return $subscriptionPermissions->exists(static fn(int $key, SubscriptionPermission $subscriptionPermission): bool => $subscriptionPermission->getPermissionKey()->getKey() === $expectedSubscriptionPermission->name);
    }

    #[Pure]
    public function isSubscription(SubscriptionEnum $expectedSubscription): bool
    {
        if (null === $subscription = $this->getSubscription()) {
            return false;
        }

        return $subscription->getKey() === $expectedSubscription->name;
    }

    public function isAlbumBelongs(Album $album): bool
    {
        return $album->getUser()->isCompare($this);
    }

    public function isMultimediaBelongs(Multimedia $multimedia): bool
    {
        return $multimedia->getUser()->isCompare($this);
    }

    public function isMultimediaMediaLibraryBelongs(MultimediaMediaLibrary $multimediaMediaLibrary): bool
    {
        return $multimediaMediaLibrary->getMediaLibrary()->isCompare($this->getMediaLibrary());
    }

    public function isMediaLibraryBelongs(MediaLibrary $mediaLibrary): bool
    {
        return $mediaLibrary->isCompare($this->getMediaLibrary());
    }

    public function isPlaylistBelongs(Playlist $playlist): bool
    {
        return $playlist->getMediaLibrary()->isCompare($this->getMediaLibrary());
    }

    public function isMultimediaPlaylistBelongs(MultimediaPlaylist $multimediaPlaylist): bool
    {
        return $multimediaPlaylist
            ->getMultimediaMediaLibrary()
            ->getMediaLibrary()
            ->isCompare($this->getMediaLibrary());
    }

    public function isPlaylistDirectoryBelongs(PlaylistDirectory $playlistDirectory): bool
    {
        return $playlistDirectory
            ->getPlaylist()
            ->getMediaLibrary()
            ->isCompare($this->getMediaLibrary());
    }

    public function isMultimediaPlaylistDirectoryBelongs(MultimediaPlaylistDirectory $multimediaPlaylistDirectory): bool
    {
        return $multimediaPlaylistDirectory
            ->getMultimediaMediaLibrary()
            ->getMediaLibrary()
            ->isCompare($this->getMediaLibrary());
    }
}