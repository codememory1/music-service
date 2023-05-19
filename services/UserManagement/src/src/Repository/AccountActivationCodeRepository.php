<?php

namespace App\Repository;

use App\Entity\AccountActivationCode;
use App\Entity\User;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class AccountActivationCodeRepository extends AbstractRepository
{
    protected ?string $entity = AccountActivationCode::class;
    protected ?string $alias = 'aac';

    public function findByUserAndCode(User $user, string $code): ?AccountActivationCode
    {
        return $this->findOneBy([
            'user' => $user,
            'code' => $code
        ]);
    }
}
