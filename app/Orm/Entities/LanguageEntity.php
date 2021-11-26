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
    #[ORM\Column(name: 'id', type: 'int', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'lang', type: 'varchar', length: 5, nullable: false)]
    #[ORM\Unique]
    private ?string $lang = null;

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
    public function setLang(string $value): static
    {

        $this->lang = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getLang(): ?string
    {

        return $this->lang;

    }

}