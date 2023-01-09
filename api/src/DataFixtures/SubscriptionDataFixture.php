<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\SubscriptionFactory;
use App\Entity\Subscription;
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
                'subscription@premium',
                'subscription@premiumDescription',
                1.99,
                SubscriptionStatusEnum::SHOW,
                isRecommend: false
            ),
            new SubscriptionFactory(
                'subscription@artist',
                'subscription@artustDescription',
                99.99,
                SubscriptionStatusEnum::SHOW,
                isRecommend: false
            ),
            new SubscriptionFactory(
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

            $this->addReference("s-{$entity->getTitle()}", $entity);
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