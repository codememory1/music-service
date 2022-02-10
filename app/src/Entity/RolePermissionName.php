<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use App\Repository\RolePermissionNameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class RolePermissionName
 *
 * @package App\Entitiy
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: RolePermissionNameRepository::class)]
#[ORM\Table('role_permission_names')]
#[ORM\HasLifecycleCallbacks]
class RolePermissionName implements EntityInterface
{

    use IdentifierTrait;
    use TimestampTrait;

    public const ADD_TRACK = 'add-music';
    public const UPDATE_TRACK = 'update-music';
    public const DELETE_TRACK = 'delete-music';
    public const CREATE_SUBSCRIPTION = 'create-subscription';
    public const UPDATE_SUBSCRIPTION = 'update-subscription';
    public const DELETE_SUBSCRIPTION = 'delete-subscription';
    public const CREATE_LANG = 'create-language';
    public const UPDATE_LANG = 'update-language';
    public const DELETE_LANG = 'delete-language';
    public const ADD_TRANSLATION = 'add-translation-to-language';
    public const UPDATE_TRANSLATION = 'update-language-translation';
    public const DELETE_TRANSLATION = 'delete-translation-from-language';

    public const NAMES = [
        self::ADD_TRACK           => 'rolePermission@addTrack',
        self::UPDATE_TRACK        => 'rolePermission@updateTrack',
        self::DELETE_TRACK        => 'rolePermission@deleteTrack',
        self::CREATE_SUBSCRIPTION => 'rolePermission@createSubscription',
        self::UPDATE_SUBSCRIPTION => 'rolePermission@updateSubscription',
        self::DELETE_SUBSCRIPTION => 'rolePermission@deleteSubscription',
        self::CREATE_LANG         => 'rolePermission@createLang',
        self::UPDATE_LANG         => 'rolePermission@updateLang',
        self::DELETE_LANG         => 'rolePermission@deleteLang',
        self::ADD_TRANSLATION     => 'rolePermission@addLangTranslation',
        self::UPDATE_TRANSLATION  => 'rolePermission@updateLangTranslation',
        self::DELETE_TRANSLATION  => 'rolePermission@deleteTranslationFromLanguage',
    ];

    /**
     * @var string|null
     */
    #[ORM\Column('`key`', Types::STRING, length: 255, unique: true, options: [
        'comment' => 'A unique key that can be used to check availability'
    ])]
    private ?string $key = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Rule name translation key'
    ])]
    private ?string $titleTranslationKey = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'rolePermissionName', targetEntity: RolePermission::class)]
    private Collection $rolePermissions;

    #[Pure]
    public function __construct()
    {

        $this->rolePermissions = new ArrayCollection();

    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {

        return $this->key;

    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key): self
    {

        $this->key = $key;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTitleTranslationKey(): ?string
    {

        return $this->titleTranslationKey;

    }

    /**
     * @param string $titleTranslationKey
     *
     * @return $this
     */
    public function setTitleTranslationKey(string $titleTranslationKey): self
    {

        $this->titleTranslationKey = $titleTranslationKey;

        return $this;

    }

    /**
     * @return Collection
     */
    public function getRolePermissions(): Collection
    {

        return $this->rolePermissions;

    }

    /**
     * @param RolePermission $rolePermission
     *
     * @return $this
     */
    public function addRolePermission(RolePermission $rolePermission): self
    {

        if (!$this->rolePermissions->contains($rolePermission)) {
            $this->rolePermissions[] = $rolePermission;
            $rolePermission->setRolePermissionName($this);
        }

        return $this;

    }

    /**
     * @param RolePermission $rolePermission
     *
     * @return $this
     */
    public function removeRolePermission(RolePermission $rolePermission): self
    {

        if ($this->rolePermissions->removeElement($rolePermission)) {
            if ($rolePermission->getRolePermissionName() === $this) {
                $rolePermission->setRolePermissionName(null);
            }
        }

        return $this;

    }

}
