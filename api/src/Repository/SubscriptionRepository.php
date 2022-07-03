<?php

namespace App\Repository;

use App\Entity\Subscription;

/**
 * Class SubscriptionRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<Subscription>
 *
 * @author  Codememory
 */
class SubscriptionRepository extends AbstractRepository
{
    protected ?string $entity = Subscription::class;
    protected ?string $alias = 's';
}
