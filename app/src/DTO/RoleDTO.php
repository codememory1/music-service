<?php

namespace App\DTO;

use App\Entity\Role;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class RoleDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class RoleDTO extends AbstractDTO
{

    /**
     * @var string|null
     */
    protected ?string $entityClass = Role::class;

    /**
     * @var string|null
     */
    private ?string $key = null;

    /**
     * @var string|null
     */
    private ?string $titleTranslationKey = null;

    /**
     * @param Role  $role
     * @param array $exclude
     *
     * @return array
     */
    #[ArrayShape([
        'id'          => "int|null",
        'key'         => "null|string",
        'title'       => "null|string",
        'permissions' => "array",
        'created_at'  => "string",
        'updated_at'  => "null|string"
    ])]
    public function toArray(Role $role, array $exclude = []): array
    {

        $role = [
            'id'          => $role->getId(),
            'key'         => $role->getKey(),
            'title'       => $role->getTitleTranslationKey(),
            'permissions' => (new RolePermissionDTO())->transform($role->getRolePermissions()->getValues()),
            'created_at'  => $role->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at'  => $role->getCreatedAt()?->format('Y-m-d H:i:s'),
        ];

        $this->excludeKeys($role, $exclude);

        return $role;

    }

    /**
     * @param string|null $key
     *
     * @return RoleDTO
     */
    public function setKey(?string $key): self
    {

        $this->key = $key;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {

        return $this->key;

    }

    /**
     * @param string|null $titleTranslationKey
     *
     * @return RoleDTO
     */
    public function setTitleTranslationKey(?string $titleTranslationKey): self
    {

        $this->titleTranslationKey = $titleTranslationKey;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTitleTranslationKey(): ?string
    {

        return $this->titleTranslationKey;

    }

}