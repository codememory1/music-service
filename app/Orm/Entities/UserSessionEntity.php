<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class UserSessionEntity
 *
 * @package App\Orm\Entities
 */
#[ORM\Entity(tableName: 'user_sessions')]
#[ORM\Repository(repository: 'App\Orm\Repositories\UserSessionRepository')]
class UserSessionEntity
{

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'id', type: 'int', length: null, nullable: false)]
    #[ORM\Identifier]
    private mixed $id = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'user_id', type: 'int', length: null, nullable: false)]
    private mixed $user_id = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'refresh_token', type: 'text', length: null, nullable: false)]
    private mixed $refresh_token = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'ip', type: 'varchar', length: 32, nullable: false)]
    private mixed $ip = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'country', type: 'varchar', length: 100, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $country = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'code_country', type: 'tinytext', length: 5, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $code_country = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'region', type: 'varchar', length: 100, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $region = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'city', type: 'varchar', length: 100, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $city = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'latitude', type: 'float', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $latitude = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'longitude', type: 'float', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $longitude = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'valid_to', type: 'datetime', length: null, nullable: false)]
    private mixed $valid_to = null;

    /**
     * @return mixed
     */
    public function getId(): mixed
    {

        return $this->id;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setUserId(mixed $value): static
    {

        $this->user_id = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getUserId(): mixed
    {

        return $this->user_id;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setRefreshToken(mixed $value): static
    {

        $this->refresh_token = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getRefreshToken(): mixed
    {

        return $this->refresh_token;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setIp(mixed $value): static
    {

        $this->ip = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getIp(): mixed
    {

        return $this->ip;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setCountry(mixed $value): static
    {

        $this->country = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getCountry(): mixed
    {

        return $this->country;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setCodeCountry(mixed $value): static
    {

        $this->code_country = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getCodeCountry(): mixed
    {

        return $this->code_country;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setRegion(mixed $value): static
    {

        $this->region = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getRegion(): mixed
    {

        return $this->region;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setCity(mixed $value): static
    {

        $this->city = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getCity(): mixed
    {

        return $this->city;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setLatitude(mixed $value): static
    {

        $this->latitude = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getLatitude(): mixed
    {

        return $this->latitude;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setLongitude(mixed $value): static
    {

        $this->longitude = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getLongitude(): mixed
    {

        return $this->longitude;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setValidTo(mixed $value): static
    {

        $this->valid_to = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getValidTo(): mixed
    {

        return $this->valid_to;

    }

}