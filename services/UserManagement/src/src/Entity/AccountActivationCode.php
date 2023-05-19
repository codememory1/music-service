<?php

namespace App\Entity;

use App\Repository\AccountActivationCodeRepository;
use Codememory\ApiBundle\Entity\Interfaces\EntityInterface;
use Codememory\ApiBundle\Entity\Traits\CreatedAtTrait;
use Codememory\ApiBundle\Entity\Traits\IdentifierTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountActivationCodeRepository::class)]
#[ORM\Table('account_activation_codes')]
#[ORM\HasLifecycleCallbacks]
class AccountActivationCode implements EntityInterface
{
    use IdentifierTrait;
    use CreatedAtTrait;

    #[ORM\ManyToOne(inversedBy: 'accountActivationCodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 6)]
    private ?string $code = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(): self
    {
        $this->code = sprintf('%06d', rand(0, 999999));

        return $this;
    }
}
