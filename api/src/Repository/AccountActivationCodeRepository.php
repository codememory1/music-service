<?php

namespace App\Repository;

use App\Entity\AccountActivationCode;
use App\Entity\User;

/**
 * Class AccountActivationCodeRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<AccountActivationCode>
 *
 * @author  Codememory
 */
class AccountActivationCodeRepository extends AbstractRepository
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
