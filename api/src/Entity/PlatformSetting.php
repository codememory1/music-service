<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\PlatformSettingEnum;
use App\Repository\PlatformSettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatformSettingRepository::class)]
#[ORM\Table('platform_settings')]
#[ORM\HasLifecycleCallbacks]
final class PlatformSetting implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

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

    public function setKey(?PlatformSettingEnum $platformSetting): self
    {
        $this->key = $platformSetting?->name;

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
