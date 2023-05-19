<?php

namespace App\Entity;

use App\Repository\PhoneCodeRepository;
use Codememory\ApiBundle\Entity\Interfaces\EntityInterface;
use Codememory\ApiBundle\Entity\Traits\IdentifierTrait;
use Codememory\ApiBundle\Entity\Traits\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhoneCodeRepository::class)]
#[ORM\Table('phone_codes')]
#[ORM\HasLifecycleCallbacks]
class PhoneCode implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\Column(length: 5, unique: true)]
    private ?string $code = null;

    #[ORM\Column(type: Types::JSON)]
    private array $suffixes = [];

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getSuffixes(): array
    {
        return $this->suffixes;
    }

    public function setSuffixes(string ...$suffixes): self
    {
        $this->suffixes = $suffixes;

        return $this;
    }
}
