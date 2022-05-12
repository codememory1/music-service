<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\TranslationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Translation.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: TranslationRepository::class)]
#[ORM\Table('translations')]
#[ORM\HasLifecycleCallbacks]
class Translation implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Language $language = null;

    #[ORM\ManyToOne(targetEntity: TranslationKey::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?TranslationKey $translationKey = null;

    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'Translation in the specified language'
    ])]
    private ?string $translation = null;

    /**
     * @return null|Language
     */
    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    /**
     * @param null|Language $language
     *
     * @return $this
     */
    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

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
