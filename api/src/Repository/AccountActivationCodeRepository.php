<?php

namespace App\Repository;

use App\Entity\AccountActivationCode;
use App\Entity\User;

/**
 * @template-extends AbstractRepository<AccountActivationCode>
 */
final class AccountActivationCodeRepository extends AbstractRepository
{
    protected ?string $entity = AccountActivationCode::class;
    protected ?string $alias = 'aac';

    public function findByUser(User $user): ?AccountActivationCode
    {
        return $this->findOneBy([
            'user' => $user
        ]);
    }

    public function findAllByUser(User $user): array
    {
        return $this->findBy(['user' => $user]);
    }

    public function findByCodeAndUser(User $user, string $code): ?AccountActivationCode
    {
        return $this->findOneBy([
            'user' => $user,
            'code' => $code
        ]);
    }
}
