<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Subscription;
use App\Entity\SubscriptionPermission;
use App\Entity\SubscriptionPermissionKey;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class SubscriptionPermissionFactory implements DataFixtureFactoryInterface
{
    private ?ReferenceRepository $referenceRepository = null;

    public function __construct(
        private readonly string $subscriptionTitle,
        private readonly SubscriptionPermissionEnum $subscriptionPermission,
        private readonly array $value = []
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        $subscriptionPermission = new SubscriptionPermission();

        /** @var Subscription $subscription */
        $subscription = $this->referenceRepository->getReference("s-{$this->subscriptionTitle}");

        /** @var SubscriptionPermissionKey $subscriptionPermissionKey */
        $subscriptionPermissionKey = $this->referenceRepository->getReference("spk-{$this->subscriptionPermission->name}");

        $subscriptionPermission->setSubscription($subscription);
        $subscriptionPermission->setPermissionKey($subscriptionPermissionKey);
        $subscriptionPermission->setValue($this->value);

        return $subscriptionPermission;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}