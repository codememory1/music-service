<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class LanguageEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'languages')]
#[ORM\Repository(repository: 'App\Orm\Repositories\LanguageRepository')]
class LanguageEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'lang_code', type: 'varchar', length: 5, nullable: false)]
    #[ORM\Unique]
    private ?string $lang_code = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setLangCode(string $value): static
    {

        $this->lang_code = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getLangCode(): ?string
    {

        return $this->lang_code;

    }

}