<?php

namespace App\Repository;

use App\Entity\User;
use App\Enum\UserStatusEnum;

/**
 * Class UserRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<User>
 *
 * @author  Codememory
 */
class UserRepository extends AbstractRepository
{
    protected ?string $entity = User::class;
    protected ?string $alias = 'u';

    public function getByEmail(?string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * @return array<User>
     */
    public function findActive(): array
    {
        return $this->findBy(['status' => UserStatusEnum::ACTIVE->name]);
    }
}
