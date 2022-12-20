<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\SubscriptionFactory;
use App\Entity\Subscription;
use App\Enum\SubscriptionEnum;
use App\Enum\SubscriptionStatusEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataFixture<Subscription>
 */
final class SubscriptionDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new SubscriptionFactory(
                SubscriptionEnum::PREMIUM,
                'subscription@premium',
                'subscription@premiumDescription',
                1.99,
                SubscriptionStatusEnum::SHOW,
                isRecommend: false
            ),
            new SubscriptionFactory(
                SubscriptionEnum::ARTIST,
                'subscription@artist',
                'subscription@artustDescription',
                99.99,
                SubscriptionStatusEnum::SHOW,
                isRecommend: false
            ),
            new SubscriptionFactory(
                SubscriptionEnum::FAMILY,
                'subscription@family',
                'subscription@familyDescription',
                5.99,
                SubscriptionStatusEnum::SHOW,
                isRecommend: true
            )
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("s-{$entity->getKey()}", $entity);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [
            TranslationDataFixture::class,
            SubscriptionPermissionKeyDataFixture::class
        ];
    }
}