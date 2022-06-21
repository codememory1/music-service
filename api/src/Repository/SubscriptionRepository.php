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
    /**
     * @inheritDoc
     */
    protected ?string $entity = Subscription::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 's';
}
