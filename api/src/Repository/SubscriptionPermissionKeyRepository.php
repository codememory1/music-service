<?php

namespace App\Repository;

use App\Entity\SubscriptionPermissionKey;

/**
 * Class SubscriptionPermissionKeyRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<SubscriptionPermissionKey>
 *
 * @author  Codememory
 */
class SubscriptionPermissionKeyRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = SubscriptionPermissionKey::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'spk';
}
