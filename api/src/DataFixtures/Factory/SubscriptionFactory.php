<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Subscription;
use App\Enum\SubscriptionEnum;
use App\Enum\SubscriptionStatusEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class SubscriptionFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class SubscriptionFactory implements DataFixtureFactoryInterface
{
    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var int
     */
    private int $price;

    /**
     * @var SubscriptionStatusEnum
     */
    private SubscriptionStatusEnum $status;

    /**
     * @var null|int
     */
    private ?int $oldPrice;

    /**
     * @var bool
     */
    private bool $isRecommend;

    /**
     * @param SubscriptionEnum       $subscriptionEnum
     * @param string                 $title
     * @param string                 $description
     * @param int                    $price
     * @param null|int               $oldPrice
     * @param SubscriptionStatusEnum $subscriptionStatusEnum
     * @param bool                   $isRecommend
     * @param array                  $permissionKeys
     */
    public function __construct(
        SubscriptionEnum $subscriptionEnum,
        string $title,
        string $description,
        int $price,
        SubscriptionStatusEnum $subscriptionStatusEnum,
        ?int $oldPrice = null,
        bool $isRecommend = false
    ) {
        $this->key = $subscriptionEnum->name;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->status = $subscriptionStatusEnum;
        $this->oldPrice = $oldPrice;
        $this->isRecommend = $isRecommend;
    }

    /**
     * @inheritDoc
     */
    public function factoryMethod(): EntityInterface
    {
        $subscriptionEntity = new Subscription();

        $subscriptionEntity->setKey($this->key);
        $subscriptionEntity->setTitle($this->title);
        $subscriptionEntity->setDescription($this->description);
        $subscriptionEntity->setOldPrice($this->oldPrice);
        $subscriptionEntity->setPrice($this->price);
        $subscriptionEntity->setIsRecommend($this->isRecommend);
        $subscriptionEntity->setStatus($this->status);

        return $subscriptionEntity;
    }

    /**
     * @inheritDoc
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}