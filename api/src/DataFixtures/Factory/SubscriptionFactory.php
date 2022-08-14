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
    private string $key;
    private string $title;
    private string $description;
    private int $price;
    private SubscriptionStatusEnum $status;
    private ?int $oldPrice;
    private bool $isRecommend;

    public function __construct(
        SubscriptionEnum $subscriptionEnum,
        string $title,
        string $description,
        int $price,
        SubscriptionStatusEnum $status,
        ?int $oldPrice = null,
        bool $isRecommend = false
    ) {
        $this->key = $subscriptionEnum->name;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->status = $status;
        $this->oldPrice = $oldPrice;
        $this->isRecommend = $isRecommend;
    }

    public function factoryMethod(): EntityInterface
    {
        $subscription = new Subscription();

        $subscription->setKey($this->key);
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