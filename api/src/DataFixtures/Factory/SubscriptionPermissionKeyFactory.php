<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\SubscriptionPermissionKey;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class SubscriptionPermissionKeyFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class SubscriptionPermissionKeyFactory implements DataFixtureFactoryInterface
{
    private string $key;
    private string $title;

    public function __construct(SubscriptionPermissionEnum $subscriptionPermissionEnum, string $title)
    {
        $this->key = $subscriptionPermissionEnum->name;
        $this->title = $title;
    }

    public function factoryMethod(): EntityInterface
    {
        $subscriptionPermissionKeyEntity = new SubscriptionPermissionKey();

        $subscriptionPermissionKeyEntity->setKey($this->key);
        $subscriptionPermissionKeyEntity->setTitle($this->title);

        return $subscriptionPermissionKeyEntity;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}