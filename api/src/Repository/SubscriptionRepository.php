<?php

namespace App\Repository;

use App\Entity\Subscription;
use App\Enum\SubscriptionEnum;

/**
 * @template-extends AbstractRepository<Subscription>
 */
final class SubscriptionRepository extends AbstractRepository
{
    protected ?string $entity = Subscription::class;
    protected ?string $alias = 's';

    public function findByName(SubscriptionEnum $name): ?Subscription
    {
        return $this->findOneBy([
            'key' => $name->name
        ]);
    }
}
