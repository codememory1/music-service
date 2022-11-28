<?php

namespace App\Repository;

use App\Entity\SubscriptionPermissionBranch;

/**
 * @template-extends AbstractRepository<SubscriptionPermissionBranch>
 */
final class SubscriptionPermissionBranchRepository extends AbstractRepository
{
    protected ?string $entity = SubscriptionPermissionBranch::class;
    protected ?string $alias = 'spb';

    public function findByKey(string $key): ?SubscriptionPermissionBranch
    {
        return $this->findOneBy(['key' => $key]);
    }
}
