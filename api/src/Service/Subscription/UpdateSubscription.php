<?php

namespace App\Service\Subscription;

use App\Dto\Transfer\SubscriptionDto;
use App\Entity\Subscription;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;

final class UpdateSubscription
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator
    ) {
    }

    public function update(SubscriptionDto $dto): Subscription
    {
        $this->validator->validate($dto);

        $this->flusher->save();

        return $dto->getEntity();
    }
}