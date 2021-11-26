<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class LanguageTranslationEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'language_translations')]
#[ORM\Repository(repository: 'App\Orm\Repositories\LanguageTranslationRepository')]
class LanguageTranslationEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'lang_id', type: 'int', length: null, nullable: false)]
    #[ORM\Reference(
        entity: LanguageEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [ReferenceDefinition::RD_CASCADE]
    )]
    private ?int $lang_id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'translation_key_id', type: 'int', length: null, nullable: false)]
    #[ORM\Reference(
        entity: TranslationKeyEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [ReferenceDefinition::RD_CASCADE]
    )]
    private ?int $translation_key_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'translation', type: 'text', length: null, nullable: false)]
    private ?string $translation = null;

    /**
     * @var LanguageEntity|null
     */
    #[ORM\Join(entity: LanguageEntity::class, columns: ['original_lang_id', 'lang'], as: ['id', 'lang'])]
    private ?LanguageEntity $lang = null;

    /**
     * @var TranslationKeyEntity|null
     */
    #[ORM\Join(entity: TranslationKeyEntity::class, columns: ['original_translation_key_id', 'key'], as: ['id', 'key'])]
    private ?TranslationKeyEntity $translationKey = null;

    /**
     * @param int $value
     *
     * @return static
     */
    public function setLangId(int $value): static
    {

        $this->lang_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getLangId(): ?int
    {

        return $this->lang_id;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setTranslationKeyId(int $value): static
    {

        $this->translation_key_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getTranslationKeyId(): ?int
    {

        return $this->translation_key_id;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setTranslation(string $value): static
    {

        $this->translation = $value;

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
     * @return LanguageEntity|null
     */
    public function getLang(): ?LanguageEntity
    {

        return $this->lang;

    }

    /**
     * @return TranslationKeyEntity|null
     */
    public function getTranslationKey(): ?TranslationKeyEntity
    {

        return $this->translationKey;

    }

}