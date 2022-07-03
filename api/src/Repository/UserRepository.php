<?php

namespace App\Repository;

use App\Entity\User;

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
}
