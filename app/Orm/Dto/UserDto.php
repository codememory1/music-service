<?php

namespace App\Orm\Dto;

use App\Orm\Entities\UserEntity;
use Codememory\Patterns\DTO\AbstractDTO;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class UserDto
 *
 * @package App\Orm\Dto
 *
 * @author  Danil
 */
final class UserDto extends AbstractDTO
{

    /**
     * @var UserEntity
     */
    private UserEntity $entity;

    /**
     * @param UserEntity $userEntity
     */
    public function __construct(UserEntity $userEntity)
    {

        $this->entity = $userEntity;

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    #[ArrayShape([
        'id'           => "int",
        'name'         => "string",
        'surname'      => "string|null",
        'patronymic'   => "string|null",
        'getBirth'     => "string|null",
        'subscription' => "int|null",
        'role'         => "int"
    ])]
    public function getTransformedData(): array
    {

        return [
            'id'           => $this->entity->getId(),
            'name'         => $this->entity->getName(),
            'surname'      => $this->entity->getSurname(),
            'patronymic'   => $this->entity->getPatronymic(),
            'getBirth'     => $this->entity->getBirth(),
            'subscription' => $this->entity->getSubscription(),
            'role'         => $this->entity->getRole()
        ];

    }

}