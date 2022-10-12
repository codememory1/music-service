<?php

namespace App\Entity;

use App\DBAL\Types\ArrayOrStringType;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\PlatformSettingEnum;
use App\Repository\PlatformSettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use function is_array;

#[ORM\Entity(repositoryClass: PlatformSettingRepository::class)]
#[ORM\Table('platform_settings')]
#[ORM\HasLifecycleCallbacks]
class PlatformSetting implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'Unique setting key to receive'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: ArrayOrStringType::NAME, options: [
        'comment' => 'Setting value'
    ])]
    private null|array|string $value = null;

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?PlatformSettingEnum $platformSetting): self
    {
        $this->key = $platformSetting?->name;

        return $this;
    }

    public function getValue(): string|array|null
    {
        return $this->value;
    }

    public function setValue(array|string|int|float $value): self
    {
        $this->value = is_array($value) ? $value : (string) $value;

        return $this;
    }
}
