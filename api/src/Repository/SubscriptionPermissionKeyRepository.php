<?php

namespace App\Repository;

use App\Entity\SubscriptionPermissionKey;

/**
 * @template-extends AbstractRepository<SubscriptionPermissionKey>
 */
final class SubscriptionPermissionKeyRepository extends AbstractRepository
{
    protected ?string $entity = SubscriptionPermissionKey::class;
    protected ?string $alias = 'spk';

    public function findByKey(string $key): ?SubscriptionPermissionKey
    {
        return $this->findOneBy(['key' => $key]);
    }
}
