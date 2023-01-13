<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Subscription;
use App\Entity\SubscriptionUiPermission;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class SubscriptionUiPermissionFactory implements DataFixtureFactoryInterface
{
    private ?ReferenceRepository $referenceRepository = null;

    public function __construct(
        private readonly string $subscriptionTitle,
        private readonly string $title,
        private readonly ?SubscriptionPermissionEnum $permission = null
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        /** @var Subscription $subscription */
        $subscription = $this->referenceRepository->getReference("s-{$this->subscriptionTitle}");

        $subscriptionUiPermission = new SubscriptionUiPermission();

        $subscriptionUiPermission->setSubscription($subscription);
        $subscriptionUiPermission->setTitle($this->title);

        if (null !== $this->permission) {
            $subscriptionUiPermission->setPermission($subscription->getPermission($this->permission));
        }

        return $subscriptionUiPermission;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}