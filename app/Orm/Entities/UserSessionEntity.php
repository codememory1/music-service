<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class UserSessionEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'user_sessions')]
#[ORM\Repository(repository: 'App\Orm\Repositories\UserSessionRepository')]
class UserSessionEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'user_id', type: 'bigint unsigned', length: null, nullable: false)]
    private ?int $user_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'refresh_token', type: 'text', length: null, nullable: false)]
    private ?string $refresh_token = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'ip', type: 'varchar', length: 32, nullable: false)]
    private ?string $ip = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'country', type: 'varchar', length: 100, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?string $country = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'code_country', type: 'tinytext', length: 5, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?string $code_country = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'region', type: 'varchar', length: 100, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?string $region = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'city', type: 'varchar', length: 100, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?string $city = null;

    /**
     * @var int|float|null
     */
    #[ORM\Column(name: 'latitude', type: 'float', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private int|float|null $latitude = null;

    /**
     * @var int|float|null
     */
    #[ORM\Column(name: 'longitude', type: 'float', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private int|float|null $longitude = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'valid_to', type: 'datetime', length: null, nullable: false)]
    private ?string $valid_to = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setUserId(int $value): static
    {

        $this->user_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {

        return $this->user_id;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setRefreshToken(string $value): static
    {

        $this->refresh_token = $value;

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
     * @param string $value
     *
     * @return static
     */
    public function setIp(string $value): static
    {

        $this->ip = $value;

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
     * @param string $value
     *
     * @return static
     */
    public function setCountry(string $value): static
    {

        $this->country = $value;

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
     * @param string $value
     *
     * @return static
     */
    public function setCodeCountry(string $value): static
    {

        $this->code_country = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getCodeCountry(): ?string
    {

        return $this->code_country;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setRegion(string $value): static
    {

        $this->region = $value;

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
     * @param string $value
     *
     * @return static
     */
    public function setCity(string $value): static
    {

        $this->city = $value;

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
     * @param int|float $value
     *
     * @return static
     */
    public function setLatitude(int|float $value): static
    {

        $this->latitude = $value;

        return $this;

    }

    /**
     * @return int|float|null
     */
    public function getLatitude(): int|null|float
    {

        return $this->latitude;

    }

    /**
     * @param int|float $value
     *
     * @return static
     */
    public function setLongitude(int|float $value): static
    {

        $this->longitude = $value;

        return $this;

    }

    /**
     * @return int|float|null
     */
    public function getLongitude(): int|null|float
    {

        return $this->longitude;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setValidTo(string $value): static
    {

        $this->valid_to = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getValidTo(): ?string
    {

        return $this->valid_to;

    }

}