<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Enum\RolePermissionNameEnum;
use App\Interface\EntityInterface;
use App\Repository\LanguageRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use App\Validator\Constraints as AppAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
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
#[AppAssert\Authorization('common@authRequired', payload: 'not_authorized')]
#[AppAssert\UserPermission(
    RolePermissionNameEnum::CREATE_LANG,
    'common@accessDenied',
    payload: 'not_enough_permissions'
)]
#[UniqueEntity(
    'code',
    'lang@codeExist',
    payload: [ApiResponseTypeEnum::CHECK_EXIST, 'code_exist']
)]
#[ORM\HasLifecycleCallbacks]
class Language implements EntityInterface
{

    use IdentifierTrait;
    use TimestampTrait;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::STRING, length: 3, unique: true, options: [
        'comment' => 'Country code consisting of two to three characters'
    ])]
    private ?string $code = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::STRING, length: 50, options: [
        'comment' => 'Language name'
    ])]
    private ?string $title = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'lang', targetEntity: Translation::class)]
    private Collection $translations;

    #[Pure]
    public function __construct()
    {

        $this->translations = new ArrayCollection();

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
