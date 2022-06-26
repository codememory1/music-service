<?php

namespace App\Repository;

use App\Entity\PasswordReset;

/**
 * Class PasswordResetRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<PasswordReset>
 *
 * @author  Codememory
 */
class PasswordResetRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = PasswordReset::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'pr';
}
