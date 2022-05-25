<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\ResponseTypeEnum;
use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Language.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: LanguageRepository::class)]
#[ORM\Table('languages')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('code', 'language@codeExist', payload: [ResponseTypeEnum::EXIST, 409])]
class Language implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\Column(type: Types::STRING, length: 5, unique: true, options: [
        'comment' => 'Abbreviated language code'
    ])]
    private ?string $code = null;

    #[ORM\Column(type: Types::STRING, length: 100, options: [
        'comment' => 'Full name of a language in its own language'
    ])]
    private ?string $originalTitle = null;

    #[ORM\OneToMany(mappedBy: 'language', targetEntity: Translation::class, cascade: ['remove'])]
    private Collection $translations;

    #[Pure]
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param null|string $code
     *
     * @return $this
     */
    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }

    /**
     * @param null|string $originalTitle
     *
     * @return $this
     */
    public function setOriginalTitle(?string $originalTitle): self
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    /**
     * @return Collection|Translation[]
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
            $translation->setLanguage($this);
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
            if ($translation->getLanguage() === $this) {
                $translation->setLanguage(null);
            }
        }

        return $this;
    }
}
