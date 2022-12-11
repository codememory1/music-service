<?php

namespace App\UseCase\Subscription;

use App\Dto\Transfer\SubscriptionDto;
use App\Entity\Subscription;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class UpdateSubscription
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function process(SubscriptionDto $dto): Subscription
    {
        $this->validator->validate($dto);

        $this->flusher->save();

        return $dto->getEntity();
    }
}