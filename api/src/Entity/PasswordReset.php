<?php

namespace App\Entity;

use App\DBAL\Types\CronTimeType;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\ValidTtlTrait;
use App\Enum\PasswordResetStatusEnum;
use App\Repository\PasswordResetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: PasswordResetRepository::class)]
#[ORM\Table('password_resets')]
#[ORM\HasLifecycleCallbacks]
class PasswordReset implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ValidTtlTrait;
    use ComparisonTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'passwordResets')]
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function generateCode(): self
    {
        $this->code = mt_rand(000000, 999999);

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(PasswordResetStatusEnum $status): self
    {
        $this->status = $status->name;

        return $this;
    }

    public function setInProcessStatus(): self
    {
        $this->setStatus(PasswordResetStatusEnum::IN_PROCESS);

        return $this;
    }

    #[Pure]
    public function isInProcess(): bool
    {
        return $this->getStatus() === PasswordResetStatusEnum::IN_PROCESS->name;
    }

    public function setCompletedStatus(): self
    {
        $this->setStatus(PasswordResetStatusEnum::COMPLETED);

        return $this;
    }

    #[Pure]
    public function isCompleted(): bool
    {
        return $this->getStatus() === PasswordResetStatusEnum::COMPLETED->name;
    }

    public function getTtl(): ?int
    {
        return $this->ttl;
    }

    public function setTtl(?string $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }
}
