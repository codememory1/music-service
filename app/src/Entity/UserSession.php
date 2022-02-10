<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\UserSessionRepository;
use App\Trait\Entity\CreatedAtTrait;
use App\Trait\Entity\IdentifierTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserSession
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
     * @var User|null
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userSessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text', options: [
        'comment' => 'Refresh token to update the access token'
    ])]
    private ?string $refresh_token = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 32, options: [
        'comment' => 'IP address of authorized user'
    ])]
    private ?string $ip = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100, nullable: true, options: [
        'comment' => 'Authorized user country'
    ])]
    private ?string $country = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 3, nullable: true, options: [
        'comment' => 'Country code in two letters'
    ])]
    private ?string $country_code = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100, nullable: true, options: [
        'comment' => 'Authorized user region'
    ])]
    private ?string $region = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100, nullable: true, options: [
        'comment' => 'Authorized user city'
    ])]
    private ?string $city = null;

    /**
     * @var float|null
     */
    #[ORM\Column(type: 'float', nullable: true, options: [
        'comment' => 'Localization by X'
    ])]
    private ?float $latitude = null;

    /**
     * @var float|null
     */
    #[ORM\Column(type: 'float', nullable: true, options: [
        'comment' => 'Localization by Y'
    ])]
    private ?float $longitude = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 10, options: [
        'comment' => 'Token lifetime in CronTime format'
    ])]
    private ?string $valid = null;

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {

        return $this->user;

    }

    /**
     * @param User|null $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {

        $this->user = $user;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string
    {

        return $this->refresh_token;

    }

    /**
     * @param string $refresh_token
     *
     * @return $this
     */
    public function setRefreshToken(string $refresh_token): self
    {

        $this->refresh_token = $refresh_token;

        return $this;

    }

    /**
     * @return string|null
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
     * @return string|null
     */
    public function getCountry(): ?string
    {

        return $this->country;

    }

    /**
     * @param string|null $country
     *
     * @return $this
     */
    public function setCountry(?string $country): self
    {

        $this->country = $country;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {

        return $this->country_code;

    }

    /**
     * @param string|null $country_code
     *
     * @return $this
     */
    public function setCountryCode(?string $country_code): self
    {

        $this->country_code = $country_code;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {

        return $this->region;

    }

    /**
     * @param string|null $region
     *
     * @return $this
     */
    public function setRegion(?string $region): self
    {

        $this->region = $region;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {

        return $this->city;

    }

    /**
     * @param string|null $city
     *
     * @return $this
     */
    public function setCity(?string $city): self
    {

        $this->city = $city;

        return $this;

    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {

        return $this->latitude;

    }

    /**
     * @param float|null $latitude
     *
     * @return $this
     */
    public function setLatitude(?float $latitude): self
    {

        $this->latitude = $latitude;

        return $this;

    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {

        return $this->longitude;

    }

    /**
     * @param float|null $longitude
     *
     * @return $this
     */
    public function setLongitude(?float $longitude): self
    {

        $this->longitude = $longitude;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getValid(): ?string
    {

        return $this->valid;

    }

    /**
     * @param string $valid
     *
     * @return $this
     */
    public function setValid(string $valid): self
    {

        $this->valid = $valid;

        return $this;

    }

}
