<?php

namespace App\Repository;

use App\Entity\User;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class UserRepository extends AbstractRepository
{
    protected ?string $entity = User::class;
    protected ?string $alias = 'u';

    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }
}
