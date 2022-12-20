<?php

namespace App\UseCase\Subscription;

use App\Dto\Transfer\SubscriptionDto;
use App\Entity\Subscription;
use App\Entity\SubscriptionPermission;
use App\Exception\Http\EntityNotFoundException;
use App\Infrastructure\Doctrine\Flusher;
use App\Repository\SubscriptionPermissionKeyRepository;

final class UpsertSubscription
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly SubscriptionPermissionKeyRepository $subscriptionPermissionKeyRepository
    ) {
    }

    public function process(SubscriptionDto $dto, Subscription $subscription): Subscription
    {
        $this->buildPermissions($dto, $subscription);

        $this->flusher->save($subscription);

        return $subscription;
    }

    private function buildPermissions(SubscriptionDto $dto, Subscription $subscription): void
    {
        foreach ($dto->permissions as $permissionData) {
            $subscriptionPermissionKey = $this->subscriptionPermissionKeyRepository->findByKey($permissionData['key']);

            if (null === $subscriptionPermissionKey) {
                throw EntityNotFoundException::subscriptionPermissionKey(['key' => $permissionData['key']]);
            }

            $subscriptionPermission = new SubscriptionPermission();

            $subscriptionPermission->setPermissionKey($subscriptionPermissionKey);
            $subscriptionPermission->setValue($permissionData['value']);

            $subscription->addPermission($subscriptionPermission);
        }
    }
}