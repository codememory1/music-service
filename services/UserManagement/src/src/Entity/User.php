<?php

namespace App\Entity;

use App\DBAL\Type\PasswordType;
use App\Enum\UserStatus;
use App\Repository\UserRepository;
use Codememory\ApiBundle\Entity\Interfaces\EntityInterface;
use Codememory\ApiBundle\Entity\Traits\IdentifierTrait;
use Codememory\ApiBundle\Entity\Traits\RemovedAtTrait;
use Codememory\ApiBundle\Entity\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
class User implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use RemovedAtTrait;

    #[ORM\Column(length: 300, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: PasswordType::NAME)]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: AccountActivationCode::class, cascade: ['persist', 'remove'])]
    private Collection $accountActivationCodes;

    public function __construct()
    {
        $this->accountActivationCodes = new ArrayCollection();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getStatus(): ?UserStatus
    {
        return null === $this->status ? null : constant(UserStatus::class."::$this->status");
    }

    public function isActivated(): bool
    {
        return $this->getStatus() === UserStatus::ACTIVATED;
    }

    public function isNotActivated(): bool
    {
        return $this->getStatus() === UserStatus::NOT_ACTIVATED;
    }

    public function isLocked(): bool
    {
        return $this->getStatus() === UserStatus::LOCKED;
    }

    public function setStatus(?UserStatus $status): self
    {
        $this->status = $status?->name;

        return $this;
    }

    /**
     * @return Collection<int, AccountActivationCode>
     */
    public function getAccountActivationCodes(): Collection
    {
        return $this->accountActivationCodes;
    }

    public function addAccountActivationCode(AccountActivationCode $accountActivationCode): self
    {
        if (!$this->accountActivationCodes->contains($accountActivationCode)) {
            $this->accountActivationCodes->add($accountActivationCode);
            $accountActivationCode->setUser($this);
        }

        return $this;
    }

    public function removeAccountActivationCode(AccountActivationCode $accountActivationCode): self
    {
        if ($this->accountActivationCodes->removeElement($accountActivationCode)) {
            // set the owning side to null (unless already changed)
            if ($accountActivationCode->getUser() === $this) {
                $accountActivationCode->setUser(null);
            }
        }

        return $this;
    }
}
