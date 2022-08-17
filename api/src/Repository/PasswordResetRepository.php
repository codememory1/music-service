<?php

namespace App\Repository;

use App\Entity\PasswordReset;

/**
 * @template-extends AbstractRepository<PasswordReset>
 */
final class PasswordResetRepository extends AbstractRepository
{
    protected ?string $entity = PasswordReset::class;
    protected ?string $alias = 'pr';
}
