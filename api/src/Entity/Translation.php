<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\TranslationRepository;
use App\Traits\Entity\IdentifierTrait;
use App\Traits\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Translation.
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
    payload: ApiResponseTypeEnum::CHECK_EXIST
)]
#[ORM\HasLifecycleCallbacks]
class Translation implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|Language
     */
    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Language $lang = null;

    /**
     * @var null|TranslationKey
     */
    #[ORM\ManyToOne(targetEntity: TranslationKey::class, cascade: ['persist', 'remove'], inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TranslationKey $translationKey = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'Translation of the key into the specified language'
    ])]
    private ?string $translation = null;

    /**
     * @return null|Language
     */
    public function getLang(): ?Language
    {
        return $this->lang;
    }

    /**
     * @param null|Language $lang
     *
     * @return $this
     */
    public function setLang(?Language $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @return null|TranslationKey
     */
    public function getTranslationKey(): ?TranslationKey
    {
        return $this->translationKey;
    }

    /**
     * @param null|TranslationKey $translationKey
     *
     * @return $this
     */
    public function setTranslationKey(?TranslationKey $translationKey): self
    {
        $this->translationKey = $translationKey;

        return $this;
    }

    /**
     * @return null|string
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
