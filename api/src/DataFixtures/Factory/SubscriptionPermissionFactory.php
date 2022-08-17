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
    private string $subscription;
    private SubscriptionPermissionEnum $subscriptionPermission;
    private ReferenceRepository $referenceRepository;

    public function __construct(SubscriptionEnum $subscriptionEnum, SubscriptionPermissionEnum $subscriptionPermission)
    {
        $this->subscription = $subscriptionEnum->name;
        $this->subscriptionPermission = $subscriptionPermission;
    }

    public function factoryMethod(): EntityInterface
    {
        $subscriptionPermission = new SubscriptionPermission();

        /** @var Subscription $subscription */
        $subscription = $this->referenceRepository->getReference("s-{$this->subscription}");

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