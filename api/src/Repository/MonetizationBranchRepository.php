<?php

namespace App\Repository;

use App\Entity\MonetizationBranch;

/**
 * @template-extends AbstractRepository<MonetizationBranch>
 */
final class MonetizationBranchRepository extends AbstractRepository
{
    protected ?string $entity = MonetizationBranch::class;
    protected ?string $alias = 'mb';
}
