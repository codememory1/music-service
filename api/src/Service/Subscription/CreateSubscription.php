<?php

namespace App\Service\Subscription;

use App\Dto\Transfer\SubscriptionDto;
use App\Entity\Subscription;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class CreateSubscription
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function create(SubscriptionDto $dto): Subscription
    {
        $this->validator->validate($dto);

        $subscription = $dto->getEntity();

        $this->flusher->save($subscription);

        return $subscription;
    }
}