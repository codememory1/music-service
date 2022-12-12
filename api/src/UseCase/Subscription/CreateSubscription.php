<?php

namespace App\UseCase\Subscription;

use App\Dto\Transfer\SubscriptionDto;
use App\Entity\Subscription;
use App\Infrastructure\Validator\Validator;

final class CreateSubscription
{
    public function __construct(
        private readonly Validator $validator,
        private readonly UpsertSubscription $upsertSubscription
    ) {
    }

    public function process(SubscriptionDto $dto): Subscription
    {
        $this->validator->validate($dto);

        return $this->upsertSubscription->process($dto, $dto->getEntity());
    }
}