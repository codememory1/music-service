<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\LanguageCodeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageCodeRepository::class)]
#[ORM\Table('language_codes')]
#[ORM\HasLifecycleCallbacks]
class LanguageCode implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\Column(type: Types::STRING, length: 2, unique: true, options: [
        'comment' => 'ISO 639 two-letter country code'
    ])]
    private ?string $twoLetterCode = null;

    #[ORM\Column(type: Types::STRING, length: 3, unique: true, options: [
        'comment' => 'Three-letter ISO 639-2 country code'
    ])]
    private ?string $threeLetterCode = null;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'The name of the language is the key to translation'
    ])]
    private ?string $titleTranslationKey = null;

    public function getTwoLetterCode(): ?string
    {
        return $this->twoLetterCode;
    }

    public function setTwoLetterCode(string $twoLetterCode): self
    {
        $this->twoLetterCode = $twoLetterCode;

        return $this;
    }

    public function getThreeLetterCode(): ?string
    {
        return $this->threeLetterCode;
    }

    public function setThreeLetterCode(string $threeLetterCode): self
    {
        $this->threeLetterCode = $threeLetterCode;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->titleTranslationKey;
    }

    public function setTitle(string $title): self
    {
        $this->titleTranslationKey = $title;

        return $this;
    }
}
