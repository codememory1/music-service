<?php

namespace App\Entity;

use App\DBAL\Types\CronTimeType;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\ValidTtlTrait;
use App\Repository\AccountActivationCodeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AccountActivationCode.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: AccountActivationCodeRepository::class)]
#[ORM\Table('account_activation_codes')]
#[ORM\HasLifecycleCallbacks]
class AccountActivationCode implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    use ValidTtlTrait;

    #[ORM\OneToOne(inversedBy: 'accountActivationCode', targetEntity: User::class)]
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
