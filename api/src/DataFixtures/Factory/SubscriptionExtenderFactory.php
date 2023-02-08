<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Subscription;
use App\Entity\SubscriptionExtender;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class SubscriptionExtenderFactory implements DataFixtureFactoryInterface
{
    private ?ReferenceRepository $referenceRepository = null;

    public function __construct(
        private readonly string $subscriptionTitle,
        private readonly string $basicSubscriptionTitle
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        /** @var Subscription $subscription */
        $subscription = $this->referenceRepository->getReference("s-{$this->subscriptionTitle}");

        /** @var Subscription $basicSubscription */
        $basicSubscription = $this->referenceRepository->getReference("s-{$this->basicSubscriptionTitle}");
        $subscriptionExtender = new SubscriptionExtender();

        $subscriptionExtender->setSubscription($subscription);
        $subscriptionExtender->setBasicSubscription($basicSubscription);

        return $subscriptionExtender;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}