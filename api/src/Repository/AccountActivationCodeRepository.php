<?php

namespace App\Repository;

use App\Entity\AccountActivationCode;

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
    /**
     * @inheritDoc
     */
    protected ?string $entity = AccountActivationCode::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'aac';
}
