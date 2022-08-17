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
}
