<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\SubscriptionExtenderFactory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class SubscriptionExtenderDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    public function __construct()
    {
        parent::__construct([
            new SubscriptionExtenderFactory('subscription@artist', 'subscription@premium'),
            new SubscriptionExtenderFactory('subscription@family', 'subscription@premium')
        ]);
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SubscriptionDataFixture::class
        ];
    }
}