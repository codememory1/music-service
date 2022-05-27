<?php

namespace App\Entity;

use App\DBAL\Types\CronTimeType;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\PasswordResetStatusEnum;
use App\Repository\PasswordResetRepository;
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

    #[ORM\OneToOne(inversedBy: 'passwordReset', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => '6-digit password change code'
    ])]
    private int $code;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'One of the PasswordResetStatusEnum statuses'
    ])]
    private ?string $status = null;

    #[ORM\Column(type: CronTimeType::NAME, length: 255, options: [
        'comment' => 'Code lifetime in CronTime format'
    ])]
    private string|int|null $ttl = null;

    public function __construct()
    {
        $this->generateCode();
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
     * @return null|int
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * @param int $code
     *
     * @return $this
     */
    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return $this
     */
    public function generateCode(): self
    {
        $this->code = mt_rand(000000, 999999);

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStatus(): ?string
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
        $this->status = $status->name;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getTtl(): ?int
    {
        return $this->ttl;
    }

    /**
     * @param null|string $ttl
     *
     * @return $this
     */
    public function setTtl(?string $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }
}
