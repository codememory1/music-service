<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\TranslationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TranslationRepository::class)]
#[ORM\Table('translations')]
#[ORM\HasLifecycleCallbacks]
class Translation implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\ManyToOne(targetEntity: Language::class, cascade: ['persist'], inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Language $language = null;

    #[ORM\ManyToOne(targetEntity: TranslationKey::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?TranslationKey $translationKey = null;

    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'Translation in the specified language'
    ])]
    private ?string $translation = null;

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getTranslationKey(): ?TranslationKey
    {
        return $this->translationKey;
    }

    public function setTranslationKey(?TranslationKey $translationKey): self
    {
        $this->translationKey = $translationKey;

        return $this;
    }

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(string $translation): self
    {
        $this->translation = $translation;

        return $this;
    }
}
