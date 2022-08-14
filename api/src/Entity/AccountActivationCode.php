<?php

namespace App\Entity;

use App\DBAL\Types\CronTimeType;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\ValidTtlTrait;
use App\Repository\AccountActivationCodeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountActivationCodeRepository::class)]
#[ORM\Table('account_activation_codes')]
#[ORM\HasLifecycleCallbacks]
final class AccountActivationCode implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ValidTtlTrait;
    use ComparisonTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'accountActivationCodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => 'A six-digit code to activate your account'
    ])]
    private ?int $code;

    #[ORM\Column(type: CronTimeType::NAME, options: [
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
