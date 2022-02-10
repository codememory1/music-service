<?php

namespace App\DTO;

use App\Entity\RolePermissionName;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class RolePermissionNameDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class RolePermissionNameDTO extends AbstractDTO
{

    /**
     * @var string|null
     */
    protected ?string $entityClass = RolePermissionName::class;

    /**
     * @var string|null
     */
    private ?string $key = null;

    /**
     * @var string|null
     */
    private ?string $titleTranslationKey = null;

    /**
     * @param RolePermissionName $rolePermissionName
     * @param array              $exclude
     *
     * @return array
     */
    #[ArrayShape([
        'id'         => "mixed",
        'title'      => "null|string",
        'created_at' => "string",
        'updated_at' => "null|string",
    ])]
    public function toArray(RolePermissionName $rolePermissionName, array $exclude = []): array
    {

        $rolePermissionName = [
            'id'         => $rolePermissionName->getId(),
            'title'      => $rolePermissionName->getTitleTranslationKey(),
            'created_at' => $rolePermissionName->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $rolePermissionName->getCreatedAt()?->format('Y-m-d H:i:s'),
        ];

        $this->excludeKeys($rolePermissionName, $exclude);

        return $rolePermissionName;

    }

    /**
     * @param string|null $key
     *
     * @return RolePermissionNameDTO
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
     * @return RolePermissionNameDTO
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