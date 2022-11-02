<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Subscription;
use App\Enum\SubscriptionEnum;
use App\Enum\SubscriptionStatusEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class SubscriptionFactory implements DataFixtureFactoryInterface
{
    public function __construct(
        private readonly SubscriptionEnum $subscriptionEnum,
        private readonly string $title,
        private readonly string $description,
        private readonly int $price,
        private readonly SubscriptionStatusEnum $status,
        private readonly ?int $oldPrice = null,
        private readonly bool $isRecommend = false
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        $subscription = new Subscription();

        $subscription->setKey($this->subscriptionEnum->name);
        $subscription->setTitle($this->title);
        $subscription->setDescription($this->description);
        $subscription->setOldPrice($this->oldPrice);
        $subscription->setPrice($this->price);
        $subscription->setIsRecommend($this->isRecommend);
        $subscription->setStatus($this->status);

        return $subscription;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}