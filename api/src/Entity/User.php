<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Enum\RoleEnum;
use App\Enum\RolePermissionNameEnum;
use App\Enum\StatusEnum;
use App\Interfaces\EntityInterface;
use App\Repository\UserRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
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
#[ORM\Table('users')]
#[UniqueEntity(
    'email',
    'user@emailExist',
    payload: ApiResponseTypeEnum::CHECK_EXIST
)]
#[UniqueEntity(
    'username',
    'user@usernameExist',
    payload: ApiResponseTypeEnum::CHECK_EXIST
)]
#[ORM\HasLifecycleCallbacks]
class User implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'User unique mail'
    ])]
    private ?string $email = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 250, unique: true, options: [
        'comment' => 'The default username is the truncated mail then the symbol @'
    ])]
    private ?string $username = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'User password hash'
    ])]
    private ?string $password = null;

    /**
     * @var null|Role
     */
    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role;

    /**
     * @var null|int
     */
    #[ORM\Column(type: Types::SMALLINT, options: [
        'comment' => 'User status, not active by default'
    ])]
    private ?int $status;

    /**
     * @var null|UserProfile
     */
    #[ORM\OneToOne(mappedBy: 'user', targetEntity: UserProfile::class, cascade: ['persist', 'remove'])]
    private ?UserProfile $userProfile = null;

    /**
     * @var null|UserSubscription
     */
    #[ORM\OneToOne(mappedBy: 'user', targetEntity: UserSubscription::class, cascade: ['persist', 'remove'])]
    private ?UserSubscription $userSubscription = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserSession::class, cascade: ['persist', 'remove'])]
    private Collection $userSessions;

    /**
     * @var null|UserActivationToken
     */
    #[ORM\OneToOne(mappedBy: 'user', targetEntity: UserActivationToken::class, cascade: ['persist', 'remove'])]
    private ?UserActivationToken $userActivationToken = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Album::class, cascade: ['persist', 'remove'])]
    private Collection $albums;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MusicRating::class, cascade: ['persist', 'remove'])]
    private Collection $musicRatings;

    /**
     * @var null|MediaLibrary
     */
    #[ORM\OneToOne(mappedBy: 'user', targetEntity: MediaLibrary::class, cascade: ['persist', 'remove'])]
    private ?MediaLibrary $mediaLibrary = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: ArtistSubscriber::class, cascade: ['persist', 'remove'])]
    private Collection $artistSubscribers;

    /**
     * @var null|AuthRestriction
     */
    #[ORM\OneToOne(mappedBy: 'user', targetEntity: AuthRestriction::class, cascade: ['persist', 'remove'])]
    private ?AuthRestriction $authRestriction = null;

    #[Pure]
    public function __construct()
    {
        $this->status = StatusEnum::NOT_ACTIVE->value;
        $this->userSessions = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->musicRatings = new ArrayCollection();
        $this->artistSubscribers = new ArrayCollection();
    }

    /**
     * @return null|string
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
     * @return null|string
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
     * @param RoleEnum $role
     *
     * @return bool
     */
    public function isRole(RoleEnum $role): bool
    {
        return $this->getRole()->getKey() === $role->value;
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
     * @param string $key
     *
     * @return bool
     */
    public function hasRole(string $key): bool
    {
        return $this->role->getKey() === $key;
    }

    /**
     * @param RolePermissionNameEnum $permission
     *
     * @return bool
     */
    public function hasPermission(RolePermissionNameEnum $permission): bool
    {
        $permissions = $this->getRole()->getRolePermissions();

        return $permissions->exists(fn(int $key, RolePermission $value) => $value->getRolePermissionName()->getKey() === $permission->value);
    }

    /**
     * @return null|int
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
     * @return null|UserProfile
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
     * @param string $key
     *
     * @return bool
     */
    public function hasSubscriptionPermission(string $key): bool
    {
        $permissions = $this->getUserSubscription()->getSubscription()->getPermissions();

        return $permissions->exists(fn(SubscriptionPermission $permission) => $permission->getSubscriptionPermissionName()->getKey() === $key);
    }

    /**
     * @return null|UserSubscription
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
     * @return null|UserActivationToken
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

    /**
     * @return Collection
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
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
            if ($album->getUser() === $this) {
                $album->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getMusicRatings(): Collection
    {
        return $this->musicRatings;
    }

    /**
     * @param MusicRating $musicRating
     *
     * @return $this
     */
    public function addMusicRating(MusicRating $musicRating): self
    {
        if (!$this->musicRatings->contains($musicRating)) {
            $this->musicRatings[] = $musicRating;
            $musicRating->setUser($this);
        }

        return $this;
    }

    /**
     * @param MusicRating $musicRating
     *
     * @return $this
     */
    public function removeMusicRating(MusicRating $musicRating): self
    {
        if ($this->musicRatings->removeElement($musicRating)) {
            // set the owning side to null (unless already changed)
            if ($musicRating->getUser() === $this) {
                $musicRating->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return null|MediaLibrary
     */
    public function getMediaLibrary(): ?MediaLibrary
    {
        return $this->mediaLibrary;
    }

    /**
     * @param MediaLibrary $mediaLibrary
     *
     * @return $this
     */
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
     * @return Collection
     */
    public function getArtistSubscribers(): Collection
    {
        return $this->artistSubscribers;
    }

    /**
     * @param ArtistSubscriber $artistSubscriber
     *
     * @return $this
     */
    public function subscribeOnArtist(ArtistSubscriber $artistSubscriber): self
    {
        if (!$this->artistSubscribers->contains($artistSubscriber)) {
            $this->artistSubscribers[] = $artistSubscriber;
            $artistSubscriber->setArtist($this);
        }

        return $this;
    }

    /**
     * @param ArtistSubscriber $artistSubscriber
     *
     * @return $this
     */
    public function unsubscribeFromArtist(ArtistSubscriber $artistSubscriber): self
    {
        if ($this->artistSubscribers->removeElement($artistSubscriber)) {
            // set the owning side to null (unless already changed)
            if ($artistSubscriber->getArtist() === $this) {
                $artistSubscriber->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return null|AuthRestriction
     */
    public function getAuthRestriction(): ?AuthRestriction
    {
        return $this->authRestriction;
    }

    /**
     * @param null|AuthRestriction $authRestriction
     *
     * @return $this
     */
    public function setAuthRestriction(?AuthRestriction $authRestriction): self
    {
        $this->authRestriction = $authRestriction;

        return $this;
    }
}
