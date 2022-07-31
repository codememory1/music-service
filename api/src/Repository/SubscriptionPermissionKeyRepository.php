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
    protected ?string $entity = SubscriptionPermissionKey::class;
    protected ?string $alias = 'spk';

    public function findByKey(string $key): ?SubscriptionPermissionKey
    {
        return $this->findOneBy(['key' => $key]);
    }
}
