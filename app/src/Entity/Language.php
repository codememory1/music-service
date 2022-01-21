<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Language
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: LanguageRepository::class)]
#[ORM\Table('languages')]
#[UniqueEntity('code', 'lang@codeExist', payload: 'code_exist')]
class Language
{

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
    #[ORM\Column(type: 'string', length: 3, unique: true, options: [
        'comment' => 'Country code consisting of two to three characters'
    ])]
    #[Assert\Length(min: 2, max: 3, minMessage: 'lang@codeMinLength', maxMessage: 'lang@codeMaxLength', payload: 'code_length')]
    private ?string $code = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, options: [
        'comment' => 'Language name'
    ])]
    #[Assert\NotBlank(message: 'common@titleIsRequired', payload: 'title_is_required')]
    #[Assert\Length(max: 255, maxMessage: 'lang@titleMaxLength', payload: 'title_length')]
    private ?string $title = null;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $updatedAt;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'lang', targetEntity: Translation::class)]
    private Collection $translations;

    public function __construct()
    {

        $this->translations = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
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
     * @return string|null
     */
    public function getCode(): ?string
    {

        return $this->code;

    }

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setCode(string $code): self
    {

        $this->code = $code;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {

        return $this->title;

    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {

        $this->title = $title;

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
     * @param DateTimeImmutable $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {

        $this->createdAt = $createdAt;

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

    /**
     * @return Collection
     */
    public function getTranslations(): Collection
    {

        return $this->translations;

    }

    /**
     * @param Translation $translation
     *
     * @return $this
     */
    public function addTranslation(Translation $translation): self
    {

        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setLang($this);
        }

        return $this;

    }

    /**
     * @param Translation $translation
     *
     * @return $this
     */
    public function removeTranslation(Translation $translation): self
    {

        if ($this->translations->removeElement($translation)) {
            // set the owning side to null (unless already changed)
            if ($translation->getLang() === $this) {
                $translation->setLang(null);
            }
        }

        return $this;

    }

}
