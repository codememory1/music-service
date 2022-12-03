<?php

namespace App\Entity;

use App\Entity\Interfaces\BranchInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\MonetizationBranchRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MonetizationBranchRepository::class)]
#[ORM\HasLifecycleCallbacks]
class MonetizationBranch implements EntityInterface, BranchInterface
{
    use IdentifierTrait;
    use UpdatedAtTrait;
    public const IGNORED_ARTISTS_KEY = 'ignored_artists';

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'The name of the key for which there is logic'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: Types::ARRAY, options: [
        'comment' => 'Key value'
    ])]
    private array $value = [];

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function setValue(array $value): self
    {
        $this->value = $value;

        return $this;
    }
}
