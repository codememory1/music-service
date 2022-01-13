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
    #[ORM\Column(name: 'id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'lang_id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Reference(
        entity: LanguageEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [ReferenceDefinition::RD_CASCADE]
    )]
    private ?int $lang_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'key', type: 'varchar', length: 255, nullable: false)]
    private ?string $key = null;

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
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

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
     * @param string $value
     *
     * @return static
     */
    public function setKey(string $value): static
    {

        $this->key = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {

        return $this->key;

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

}