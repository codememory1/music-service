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

    #[ORM\Column(type: Types::STRING, length: 100, nullable: true, options: [
        'comment' => 'Continent'
    ])]
    private ?string $continent = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: [
        'comment' => 'The city in which the account was logged out or registered'
    ])]
    private ?string $city = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: [
        'comment' => 'The country in which the account was logged out or registered'
    ])]
    private ?string $country = null;

    #[ORM\Column(type: Types::STRING, length: 10, nullable: true, options: [
        'comment' => 'Code of the country'
    ])]
    private ?string $countryCode = null;

    #[ORM\Column(type: Types::STRING, length: 10, nullable: true, options: [
        'comment' => 'Region code'
    ])]
    private ?string $region = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: [
        'comment' => 'Region name'
    ])]
    private ?string $regionName = null;

    #[ORM\Column(type: Types::STRING, length: 100, nullable: true, options: [
        'comment' => 'Time zone'
    ])]
    private ?string $timezone = null;

    #[ORM\Column(type: Types::STRING, length: 10, nullable: true, options: [
        'comment' => 'Country currency'
    ])]
    private ?string $currency = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?UserSessionTypeEnum $type): self
    {
        $this->type = $type->name;

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(?string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(?string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    public function setBrowser(?string $browser): self
    {
        $this->browser = $browser;

        return $this;
    }

    public function getDevice(): ?string
    {
        return $this->device;
    }

    public function setDevice(?string $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function getOperatingSystem(): ?string
    {
        return $this->operatingSystem;
    }

    public function setOperatingSystem(?string $operatingSystem): self
    {
        $this->operatingSystem = $operatingSystem;

        return $this;
    }

    public function getContinent(): ?string
    {
        return $this->continent;
    }

    public function setContinent(?string $continent): self
    {
        $this->continent = $continent;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getRegionName(): ?string
    {
        return $this->regionName;
    }

    public function setRegionName(?string $regionName): self
    {
        $this->regionName = $regionName;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCoordinates(): ?array
    {
        return $this->coordinates;
    }

    public function setCoordinates(array $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    public function getLastActivity(): ?DateTimeInterface
    {
        return $this->lastActivity;
    }

    public function setLastActivity(?DateTimeInterface $lastActivity): self
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }
}
