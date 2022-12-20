<?php

namespace App\Repository;

use App\Entity\PasswordReset;
use App\Entity\User;
use App\Enum\PasswordResetStatusEnum;

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

    public function findByCodeAndUserInProcess(User $user, string $code): ?PasswordReset
    {
        return $this->findOneBy([
            'user' => $user,
            'code' => $code,
            'status' => PasswordResetStatusEnum::IN_PROCESS->name
        ]);
    }
}
