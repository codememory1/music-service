<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\UserSessionRepository;
use App\Traits\Entity\CreatedAtTrait;
use App\Traits\Entity\IdentifierTrait;
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

    use CreatedAtTrait;

    /**
     * @var null|User
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userSessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'Refresh token to update the access token'
    ])]
    private ?string $refreshToken = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 32, options: [
        'comment' => 'IP address of authorized user'
    ])]
    private ?string $ip = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 100, nullable: true, options: [
        'comment' => 'Authorized user country'
    ])]
    private ?string $country = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 3, nullable: true, options: [
        'comment' => 'Country code in two letters'
    ])]
    private ?string $countryCode = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 100, nullable: true, options: [
        'comment' => 'Authorized user region'
    ])]
    private ?string $region = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 100, nullable: true, options: [
        'comment' => 'Authorized user city'
    ])]
    private ?string $city = null;

    /**
     * @var null|float
     */
    #[ORM\Column(type: Types::FLOAT, nullable: true, options: [
        'comment' => 'Localization by X'
    ])]
    private ?float $latitude = null;

    /**
     * @var null|float
     */
    #[ORM\Column(type: Types::FLOAT, nullable: true, options: [
        'comment' => 'Localization by Y'
    ])]
    private ?float $longitude = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 50)]
    private ?string $deviceModel = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 50)]
    private ?string $operatingSystem = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 50)]
    private ?string $browser = null;

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
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     *
     * @return $this
     */
    public function setRefreshToken(string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

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
     * @param string $ip
     *
     * @return $this
     */
    public function setIp(string $ip): self
    {
        $this->ip = $ip;

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
     * @return null|string
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @param null|string $countryCode
     *
     * @return $this
     */
    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param null|string $region
     *
     * @return $this
     */
    public function setRegion(?string $region): self
    {
        $this->region = $region;

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
     * @return null|float
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param null|float $latitude
     *
     * @return $this
     */
    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return null|float
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param null|float $longitude
     *
     * @return $this
     */
    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDeviceModel(): ?string
    {
        return $this->deviceModel;
    }

    /**
     * @param null|string $deviceModel
     *
     * @return $this
     */
    public function setDeviceModel(?string $deviceModel): self
    {
        $this->deviceModel = $deviceModel;

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
}
