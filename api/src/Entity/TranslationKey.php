<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\TranslationKeyRepository;
use App\Traits\Entity\IdentifierTrait;
use App\Traits\Entity\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class TranslationKey.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: TranslationKeyRepository::class)]
#[ORM\Table('translation_keys')]
#[UniqueEntity(
    'name',
    'translationKey@keyExist',
    payload: ApiResponseTypeEnum::CHECK_EXIST
)]
#[ORM\HasLifecycleCallbacks]
class TranslationKey implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'A unique key by which it will be possible to receive a transfer'
    ])]
    private ?string $name = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'translationKey', targetEntity: Translation::class)]
    private Collection $translations;

    #[Pure]
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    /**
     * @return null|string
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
