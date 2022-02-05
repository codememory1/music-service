<?php

namespace App\Entity;

use App\Repository\UserActivationTokenRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserActivationToken
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserActivationTokenRepository::class)]
#[ORM\Table('user_activation_tokens')]
#[ORM\HasLifecycleCallbacks]
class UserActivationToken
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var User|null
     */
    #[ORM\OneToOne(inversedBy: 'userActivationToken', targetEntity: User::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 10, options: [
        'comment' => 'Token lifetime in CronTime format'
    ])]
    private ?string $valid = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text', options: [
        'comment' => 'Account activation token'
    ])]
    private ?string $token = null;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @return User|null
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

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {

        return $this->token;

    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken(string $token): self
    {

        $this->token = $token;

        return $this;

    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {

        return $this->createdAt;

    }

    /**
     * @return $this
     */
    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {

        $this->createdAt = new DateTimeImmutable();

        return $this;

    }

}
