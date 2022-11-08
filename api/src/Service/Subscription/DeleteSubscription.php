<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Service\FlusherService;

final class DeleteSubscription
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function delete(Subscription $subscription): Subscription
    {
        $this->flusher->remove($subscription);

        return $subscription;
    }
}