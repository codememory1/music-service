<?php

namespace App\Entity;

use App\Enum\PasswordResetStatusEnum;
use App\Interfaces\EntityInterface;
use App\Repository\PasswordResetRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PasswordReset.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: PasswordResetRepository::class)]
#[ORM\Table('password_resets')]
#[ORM\HasLifecycleCallbacks]
class PasswordReset implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|int
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    /**
     * @var null|User
     */
    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'Password reset token'
    ])]
    private ?string $token = null;

    /**
     * @var bool
     */
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $executed = false;

    /**
     * @var null|int
     */
    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => 'Token status'
    ])]
    private ?int $status = null;

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
     * @return null|int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param PasswordResetStatusEnum $status
     *
     * @return $this
     */
    public function setStatus(PasswordResetStatusEnum $status): self
    {
        $this->status = $status->value;

        return $this;
    }

    /**
     * @return bool
     */
    public function getExecuted(): bool
    {
        return $this->executed;
    }

    /**
     * @param bool $executed
     *
     * @return $this
     */
    public function setExecuted(bool $executed): self
    {
        $this->executed = $executed;

        return $this;
    }
}
