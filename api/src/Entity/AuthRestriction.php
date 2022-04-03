<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\AuthRestrictionRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\UpdatedAtTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AuthRestriction.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: AuthRestrictionRepository::class)]
#[ORM\Table('auth_restrictions')]
#[ORM\HasLifecycleCallbacks]
class AuthRestriction implements EntityInterface
{
    use IdentifierTrait;

    use UpdatedAtTrait;

    /**
     * @var null|User
     */
    #[ORM\OneToOne(inversedBy: 'authRestriction', targetEntity: User::class)]
    #[ORM\JoinColumn(unique: true, nullable: false)]
    private ?User $user = null;

    /**
     * @var array
     */
    #[ORM\Column(type: Types::JSON)]
    private array $devices = [];

    /**
     * @var array
     */
    #[ORM\Column(type: Types::JSON)]
    private array $operatingSystems = [];

    /**
     * @var array
     */
    #[ORM\Column(type: Types::JSON)]
    private array $browsers = [];

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getDevices(): ?array
    {
        return $this->devices;
    }

    /**
     * @param array $devices
     *
     * @return $this
     */
    public function setDevices(array $devices): self
    {
        $this->devices = $devices;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getOperatingSystems(): ?array
    {
        return $this->operatingSystems;
    }

    /**
     * @param array $operatingSystems
     *
     * @return $this
     */
    public function setOperatingSystems(array $operatingSystems): self
    {
        $this->operatingSystems = $operatingSystems;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getBrowsers(): ?array
    {
        return $this->browsers;
    }

    /**
     * @param array $browsers
     *
     * @return $this
     */
    public function setBrowsers(array $browsers): self
    {
        $this->browsers = $browsers;

        return $this;
    }
}
