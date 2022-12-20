<?php

namespace App\Repository;

use App\Entity\SubscriptionPayment;

/**
 * @extends AbstractRepository<SubscriptionPayment>
 */
final class SubscriptionPaymentRepository extends AbstractRepository
{
    protected ?string $entity = SubscriptionPayment::class;
    protected ?string $alias = 'sp';
}
