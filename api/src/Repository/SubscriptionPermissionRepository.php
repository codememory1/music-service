<?php

namespace App\Repository;

use App\Entity\SubscriptionPermission;

/**
 * Class SubscriptionPermissionRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<SubscriptionPermission>
 *
 * @author  Codememory
 */
class SubscriptionPermissionRepository extends AbstractRepository
{
    protected ?string $entity = SubscriptionPermission::class;
    protected ?string $alias = 'sp';
}
