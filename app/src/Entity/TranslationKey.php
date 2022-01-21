<?php

namespace App\Entity;

use App\Repository\TranslationKeyRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class TranslationKey
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: TranslationKeyRepository::class)]
#[ORM\Table('translation_keys')]
#[UniqueEntity('key', 'translationKey@keyExist', payload: 'key_exist')]
class TranslationKey
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
    #[ORM\Column(type: 'string', length: 255, unique: true, options: [
        'comment' => 'A unique key by which it will be possible to receive a transfer'
    ])]
    #[Assert\NotBlank(message: 'translationKey@nameIsRequired', payload: 'name_is_required')]
    #[Assert\Length(max: 255, maxMessage: 'translationKey@nameMaxLength', payload: 'name_length')]
    private ?string $name = null;

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
    #[ORM\OneToMany(mappedBy: 'translationKey', targetEntity: Translation::class)]
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
    public function getName(): ?string
    {

        return $this->name;

    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
            $translation->setTranslationKey($this);
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
            if ($translation->getTranslationKey() === $this) {
                $translation->setTranslationKey(null);
            }
        }

        return $this;

    }

}
