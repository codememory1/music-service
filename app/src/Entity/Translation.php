<?php

namespace App\Entity;

use App\Enums\ApiResponseTypeEnum;
use App\Repository\TranslationRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Translation
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: TranslationRepository::class)]
#[ORM\Table('translations')]
#[UniqueEntity(['lang', 'translationKey'], 'translation@exist', payload: [ApiResponseTypeEnum::CHECK_EXIST, 'translation_exist'])]
#[ORM\HasLifecycleCallbacks]
class Translation
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

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
    #[ORM\Column(type: 'text', options: [
        'comment' => 'Translation of the key into the specified language'
    ])]
    #[Assert\NotBlank(message: 'translation@translationIsRequired', payload: 'translation_is_required')]
    private ?string $translation = null;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt = null;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $updatedAt;

    public function __construct()
    {

        $this->updatedAt = new DateTimeImmutable();

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

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

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {

        return $this->createdAt;

    }

    /**
     * @return $this
     */
    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {

        $this->createdAt = new DateTimeImmutable();

        return $this;

    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getUpdatedAt(): ?DateTimeImmutable
    {

        return $this->updatedAt;

    }

    /**
     * @param DateTimeImmutable $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {

        $this->updatedAt = $updatedAt;

        return $this;

    }

}