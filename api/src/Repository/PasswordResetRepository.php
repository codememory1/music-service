<?php

namespace App\Repository;

use App\Entity\PasswordReset;
use App\Entity\User;

/**
 * @template-extends AbstractRepository<PasswordReset>
 */
final class PasswordResetRepository extends AbstractRepository
{
    protected ?string $entity = PasswordReset::class;
    protected ?string $alias = 'pr';

    public function findAllByUser(User $user): array
    {
        return $this->findBy(['user' => $user]);
    }
}
