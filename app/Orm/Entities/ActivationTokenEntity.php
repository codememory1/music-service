<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class ActivationTokenEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'activation_tokens')]
#[ORM\Repository(repository: 'App\Orm\Repositories\ActivationTokenRepository')]
class ActivationTokenEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'id', type: 'int', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'user_id', type: 'int', length: null, nullable: false)]
    #[ORM\Reference(entity: UserEntity::class, referencedColumnName: 'id', on: [RelationshipInterface::ON_DELETE], onOptions: [ReferenceDefinition::RD_CASCADE])]
    private ?int $user_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'token', type: 'text', length: null, nullable: false)]
    private ?string $token = null;

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
    public function setUserId(int $value): static
    {

        $this->user_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {

        return $this->user_id;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setToken(string $value): static
    {

        $this->token = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {

        return $this->token;

    }

}