<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\UserSessionTypeEnum;
use App\Repository\UserSessionRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserSession.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserSessionRepository::class)]
#[ORM\Table('user_sessions')]
#[ORM\HasLifecycleCallbacks]
class UserSession implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Session type from UserSessionTypeEnum enumeration'
    ])]
    private ?string $type;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: [
        'comment' => 'Access Token for which access will be provided'
    ])]
    private ?string $accessToken = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: [
        'comment' => 'Refresh Token for refreshing Access Token and for getting session information'
    ])]
    private ?string $refreshToken = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true, options: [
        'comment' => 'Is the session active now'
    ])]
    private bool $isActive = false;

    #[ORM\Column(type: Types::STRING, length: 50, nullable: true, options: [
        'comment' => 'The IP address from which the account was logged out or registered'
    ])]
    private ?string $ip = null;

    #[ORM\Column(type: Types::STRING, length: 50, nullable: true, options: [
        'comment' => 'The browser from which the account was logged out or registered'
    ])]
    private ?string $browser = null;

    #[ORM\Column(type: Types::STRING, length: 25, nullable: true, options: [
        'comment' => 'The model of the device from which the account was logged out or registered'
    ])]
    private ?string $device = null;

    #[ORM\Column(type: Types::STRING, length: 25, nullable: true, options: [
        'comment' => 'The operating system of the device from which the account was logged out or registered'
    ])]
    private ?string $operatingSystem = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: [
        'comment' => 'The city in which the account was logged out or registered'
    ])]
    private ?string $city = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: [
        'comment' => 'The country in which the account was logged out or registered'
    ])]
    private ?string $country = null;

    #[ORM\Column(type: Types::ARRAY, options: [
        'comment' => 'The authority in which the account was logged out or registered'
    ])]
    private array $coordinates = [];

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'Date of last activity on the account'
    ])]
    private ?DateTimeImmutable $lastActivity = null;

    public function __construct()
    {
        $this->type = UserSessionTypeEnum::TEMP->name;
    }

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

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
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|UserSessionTypeEnum $type
     *
     * @return $this
     */
    public function setType(?UserSessionTypeEnum $type): self
    {
        $this->type = $type->name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @param null|string $accessToken
     *
     * @return $this
     */
    public function setAccessToken(?string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    /**
     * @param null|string $refreshToken
     *
     * @return $this
     */
    public function setRefreshToken(?string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * @return null|bool
     */
    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     *
     * @return $this
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param null|string $ip
     *
     * @return $this
     */
    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    /**
     * @param null|string $browser
     *
     * @return $this
     */
    public function setBrowser(?string $browser): self
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDevice(): ?string
    {
        return $this->device;
    }

    /**
     * @param null|string $device
     *
     * @return $this
     */
    public function setDevice(?string $device): self
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getOperatingSystem(): ?string
    {
        return $this->operatingSystem;
    }

    /**
     * @param null|string $operatingSystem
     *
     * @return $this
     */
    public function setOperatingSystem(?string $operatingSystem): self
    {
        $this->operatingSystem = $operatingSystem;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param null|string $city
     *
     * @return $this
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param null|string $country
     *
     * @return $this
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getCoordinates(): ?array
    {
        return $this->coordinates;
    }

    /**
     * @param array $coordinates
     *
     * @return $this
     */
    public function setCoordinates(array $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * @return null|DateTimeInterface
     */
    public function getLastActivity(): ?DateTimeInterface
    {
        return $this->lastActivity;
    }

    /**
     * @param null|DateTimeInterface $lastActivity
     *
     * @return $this
     */
    public function setLastActivity(?DateTimeInterface $lastActivity): self
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }
}
