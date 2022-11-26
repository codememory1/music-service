<?php

namespace App\Repository;

use App\Entity\LogicBranch;

/**
 * @template-extends AbstractRepository<LogicBranch>
 */
final class LogicBranchRepository extends AbstractRepository
{
    protected ?string $entity = LogicBranch::class;
    protected ?string $alias = 'lb';
}
