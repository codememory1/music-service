<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait BranchTrait
{
    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'The name of the key for which there is logic'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: Types::JSON, options: [
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