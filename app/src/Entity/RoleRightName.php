<?php

namespace App\Entity;

use App\Repository\RoleRightNameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class RoleRightName
 *
 * @package App\Entitiy
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: RoleRightNameRepository::class)]
#[ORM\Table('role_right_names')]
class RoleRightName
{

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
        self::ADD_TRACK           => 'roleRightName@addTrack',
        self::UPDATE_TRACK        => 'roleRightName@updateTrack',
        self::DELETE_TRACK        => 'roleRightName@deleteTrack',
        self::CREATE_SUBSCRIPTION => 'roleRightName@createSubscription',
        self::UPDATE_SUBSCRIPTION => 'roleRightName@updateSubscription',
        self::DELETE_SUBSCRIPTION => 'roleRightName@deleteSubscription',
        self::CREATE_LANG         => 'roleRightName@createLang',
        self::UPDATE_LANG         => 'roleRightName@updateLang',
        self::DELETE_LANG         => 'roleRightName@deleteLang',
        self::ADD_TRANSLATION     => 'roleRightName@addLangTranslation',
        self::UPDATE_TRANSLATION  => 'roleRightName@updateLangTranslation',
        self::DELETE_TRANSLATION  => 'roleRightName@deleteTranslationFromLanguage',
    ];

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column('`key`', 'string', length: 255, unique: true, options: [
        'comment' => 'A unique key that can be used to check availability'
    ])]
    private ?string $key = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, options: [
        'comment' => 'Rule name translation key'
    ])]
    private ?string $titleTranslationKey = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'roleRightName', targetEntity: RoleRight::class)]
    private Collection $roleRights;

    #[Pure]
    public function __construct()
    {

        $this->roleRights = new ArrayCollection();

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

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
    public function getRoleRights(): Collection
    {

        return $this->roleRights;

    }

    /**
     * @param RoleRight $roleRight
     *
     * @return $this
     */
    public function addRoleRight(RoleRight $roleRight): self
    {

        if (!$this->roleRights->contains($roleRight)) {
            $this->roleRights[] = $roleRight;
            $roleRight->setRoleRightName($this);
        }

        return $this;

    }

    /**
     * @param RoleRight $roleRight
     *
     * @return $this
     */
    public function removeRoleRight(RoleRight $roleRight): self
    {

        if ($this->roleRights->removeElement($roleRight)) {
            if ($roleRight->getRoleRightName() === $this) {
                $roleRight->setRoleRightName(null);
            }
        }

        return $this;

    }

}
