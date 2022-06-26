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
    /**
     * @inheritDoc
     */
    protected ?string $entity = SubscriptionPermission::class;
}
