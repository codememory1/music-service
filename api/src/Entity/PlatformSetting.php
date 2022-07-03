<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\PlatformSettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PlatformSetting.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: PlatformSettingRepository::class)]
#[ORM\Table('platform_settings')]
#[ORM\HasLifecycleCallbacks]
class PlatformSetting implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'Unique setting key to receive'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: Types::ARRAY, options: [
        'comment' => 'Setting value'
    ])]
    private array $value = [];

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value['value'] ?? null;
    }

    public function setValue(mixed $value): self
    {
        $this->value = ['value' => $value];

        return $this;
    }
}
