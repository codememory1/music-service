<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Subscription;
use App\Entity\SubscriptionPermission;
use App\Entity\SubscriptionPermissionKey;
use App\Enum\SubscriptionEnum;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class SubscriptionPermissionFactory implements DataFixtureFactoryInterface
{
    private ?ReferenceRepository $referenceRepository = null;

    public function __construct(
        private readonly SubscriptionEnum $subscription,
        private readonly SubscriptionPermissionEnum $subscriptionPermission
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        $subscriptionPermission = new SubscriptionPermission();

        /** @var Subscription $subscription */
        $subscription = $this->referenceRepository->getReference("s-{$this->subscription->name}");

        /** @var SubscriptionPermissionKey $subscriptionPermissionKey */
        $subscriptionPermissionKey = $this->referenceRepository->getReference("spk-{$this->subscriptionPermission->name}");

        $subscriptionPermission->setSubscription($subscription);
        $subscriptionPermission->setPermissionKey($subscriptionPermissionKey);

        return $subscriptionPermission;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}