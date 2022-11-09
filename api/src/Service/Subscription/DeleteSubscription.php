<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteSubscription
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function delete(Subscription $subscription): Subscription
    {
        $this->flusher->remove($subscription);

        return $subscription;
    }
}