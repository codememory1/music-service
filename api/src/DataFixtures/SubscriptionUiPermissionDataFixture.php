<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\SubscriptionUiPermissionFactory;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class SubscriptionUiPermissionDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    public function __construct()
    {
        parent::__construct([
            new SubscriptionUiPermissionFactory('subscription@premium', 'subscriptionUiPermissions.musicWithoutCommercials'),
            new SubscriptionUiPermissionFactory('subscription@premium', 'subscriptionUiPermissions.uniqueFunctionality'),
            new SubscriptionUiPermissionFactory('subscription@premium', 'subscriptionUiPermissions.eventForMediaLibraryAndItsComponents'),
            new SubscriptionUiPermissionFactory('subscription@premium', 'subscriptionUiPermissions.addFriendsAndShareMultimedia'),

            new SubscriptionUiPermissionFactory('subscription@family', 'subscriptionUiPermissions.subscriptionForMultipleAccounts', SubscriptionPermissionEnum::NUMBER_CONNECTED_ACCOUNTS),
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