<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\SubscriptionPermissionKey;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class SubscriptionPermissionKeyFactory implements DataFixtureFactoryInterface
{
    public function __construct(
        private readonly SubscriptionPermissionEnum $subscriptionPermission,
        private readonly string $title
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        $subscriptionPermissionKey = new SubscriptionPermissionKey();

        $subscriptionPermissionKey->setKey($this->subscriptionPermission);
        $subscriptionPermissionKey->setTitle($this->title);

        return $subscriptionPermissionKey;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}