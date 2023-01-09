<?php

namespace App\Repository;

use App\Entity\Subscription;

/**
 * @template-extends AbstractRepository<Subscription>
 */
final class SubscriptionRepository extends AbstractRepository
{
    protected ?string $entity = Subscription::class;
    protected ?string $alias = 's';
}
