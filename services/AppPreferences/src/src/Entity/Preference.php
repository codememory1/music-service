<?php

namespace App\Entity;

use App\Repository\PreferenceRepository;
use Codememory\ApiBundle\Entity\Interfaces\EntityInterface;
use Codememory\ApiBundle\Entity\Traits\IdentifierTrait;
use Codememory\ApiBundle\Entity\Traits\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceRepository::class)]
#[ORM\Table('preferences')]
#[ORM\HasLifecycleCallbacks]
class Preference implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $key = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $value = null;

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(mixed $value): self
    {
        $this->value = is_array($value) ? json_encode($value) : $value;

        return $this;
    }
}
