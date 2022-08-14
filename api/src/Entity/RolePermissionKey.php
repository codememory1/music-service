<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\RolePermissionEnum;
use App\Repository\RolePermissionKeyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolePermissionKeyRepository::class)]
#[ORM\Table('role_permission_keys')]
#[ORM\HasLifecycleCallbacks]
final class RolePermissionKey implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'Unique key, to verify the right'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'The name of this right as a translation key'
    ])]
    private ?string $titleTranslationKey = null;

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?RolePermissionEnum $rolePermission): self
    {
        $this->key = $rolePermission?->name;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->titleTranslationKey;
    }

    public function setTitle(?string $titleTranslationKey): self
    {
        $this->titleTranslationKey = $titleTranslationKey;

        return $this;
    }
}
