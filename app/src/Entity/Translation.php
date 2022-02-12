<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Enum\RolePermissionNameEnum;
use App\Interface\EntityInterface;
use App\Repository\TranslationRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use App\Validator\Constraints as AppAssert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Translation
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: TranslationRepository::class)]
#[ORM\Table('translations')]
#[UniqueEntity(
    ['lang', 'translationKey'],
    'translation@exist',
    payload: [ApiResponseTypeEnum::CHECK_EXIST, 'translation_exist']
)]
#[AppAssert\Authorization('common@authRequired', payload: 'not_authorized')]
#[AppAssert\UserPermission(
    RolePermissionNameEnum::CREATE_TRANSLATION,
    'common@accessDenied',
    payload: 'not_enough_permissions'
)]
#[ORM\HasLifecycleCallbacks]
class Translation implements EntityInterface
{

    use IdentifierTrait;
    use TimestampTrait;

    /**
     * @var Language|null
     */
    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Language $lang = null;

    /**
     * @var TranslationKey|null
     */
    #[ORM\ManyToOne(targetEntity: TranslationKey::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TranslationKey $translationKey = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'Translation of the key into the specified language'
    ])]
    private ?string $translation = null;

    /**
     * @return Language|null
     */
    public function getLang(): ?Language
    {

        return $this->lang;

    }

    /**
     * @param Language|null $lang
     *
     * @return $this
     */
    public function setLang(?Language $lang): self
    {

        $this->lang = $lang;

        return $this;

    }

    /**
     * @return TranslationKey|null
     */
    public function getTranslationKey(): ?TranslationKey
    {

        return $this->translationKey;

    }

    /**
     * @param TranslationKey|null $translationKey
     *
     * @return $this
     */
    public function setTranslationKey(?TranslationKey $translationKey): self
    {

        $this->translationKey = $translationKey;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTranslation(): ?string
    {

        return $this->translation;

    }

    /**
     * @param string $translation
     *
     * @return $this
     */
    public function setTranslation(string $translation): self
    {

        $this->translation = $translation;

        return $this;

    }

}
