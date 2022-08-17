<?php

namespace App\Repository;

use App\Entity\SubscriptionPermission;

/**
 * @template-extends AbstractRepository<SubscriptionPermission>
 */
final class SubscriptionPermissionRepository extends AbstractRepository
{
    protected ?string $entity = SubscriptionPermission::class;
    protected ?string $alias = 'sp';
}
