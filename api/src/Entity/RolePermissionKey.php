<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\RolePermissionKeyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RolePermissionKey.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: RolePermissionKeyRepository::class)]
#[ORM\Table('role_permission_keys')]
#[ORM\HasLifecycleCallbacks]
class RolePermissionKey implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'Unique key, to verify the right'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'The name of this right as a translation key'
    ])]
    private ?string $titleTranslationKey = null;

    /**
     * @return null|string
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param null|string $key
     *
     * @return $this
     */
    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->titleTranslationKey;
    }

    /**
     * @param null|string $titleTranslationKey
     *
     * @return $this
     */
    public function setTitle(?string $titleTranslationKey): self
    {
        $this->titleTranslationKey = $titleTranslationKey;

        return $this;
    }
}
