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

/**
 * Class SubscriptionPermissionFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class SubscriptionPermissionFactory implements DataFixtureFactoryInterface
{
    private string $subscription;
    private string $subscriptionPermission;
    private ReferenceRepository $referenceRepository;

    public function __construct(SubscriptionEnum $subscriptionEnum, SubscriptionPermissionEnum $subscriptionPermissionEnum)
    {
        $this->subscription = $subscriptionEnum->name;
        $this->subscriptionPermission = $subscriptionPermissionEnum->name;
    }

    public function factoryMethod(): EntityInterface
    {
        $subscriptionPermissionEntity = new SubscriptionPermission();

        /** @var Subscription $subscription */
        $subscription = $this->referenceRepository->getReference("s-{$this->subscription}");

        /** @var SubscriptionPermissionKey $subscriptionPermissionKey */
        $subscriptionPermissionKey = $this->referenceRepository->getReference("spk-{$this->subscriptionPermission}");

        $subscriptionPermissionEntity->setSubscription($subscription);
        $subscriptionPermissionEntity->setPermissionKey($subscriptionPermissionKey);

        return $subscriptionPermissionEntity;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}