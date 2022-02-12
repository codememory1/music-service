<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Enum\RolePermissionNameEnum;
use App\Interface\EntityInterface;
use App\Repository\AlbumTypeRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class AlbumType
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: AlbumTypeRepository::class)]
#[ORM\Table('album_types')]
#[AppAssert\Authorization('common@authRequired', payload: 'not_authorized')]
#[AppAssert\UserPermission(
    RolePermissionNameEnum::CREATE_ALBUM_TYPE,
    'common@accessDenied',
    payload: 'not_enough_permissions'
)]
#[UniqueEntity(
    'key',
    'albumType@keyExist',
    payload: [ApiResponseTypeEnum::CHECK_EXIST, 'key_exist']
)]
#[ORM\HasLifecycleCallbacks]
class AlbumType implements EntityInterface
{

    use IdentifierTrait;
    use TimestampTrait;

    /**
     * @var string|null
     */
    #[ORM\Column('`key`', 'string', length: 255, unique: true, options: [
        'comment' => 'Unique album type'
    ])]
    private ?string $key = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, options: [
        'comment' => 'Type name translation key'
    ])]
    private ?string $titleTranslationKey = null;

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

}
