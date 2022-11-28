<?php

namespace App\Repository;

use App\Entity\LogicBranch;
use App\Enum\LogicBranchEnum;

/**
 * @template-extends AbstractRepository<LogicBranch>
 */
final class LogicBranchRepository extends AbstractRepository
{
    protected ?string $entity = LogicBranch::class;
    protected ?string $alias = 'lb';

    public function findByName(LogicBranchEnum $name): ?LogicBranch
    {
        return $this->findOneBy(['name' => $name->name]);
    }
}
