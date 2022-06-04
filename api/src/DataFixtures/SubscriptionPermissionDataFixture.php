<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\SubscriptionPermissionFactory;
use App\Enum\SubscriptionEnum;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class SubscriptionPermissionDataFixture.
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
final class SubscriptionPermissionDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::SHOW_MY_ALBUMS),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::CREATE_ALBUM),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::UPDATE_ALBUM),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::DELETE_ALBUM),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [
            SubscriptionPermissionKeyDataFixture::class,
            SubscriptionDataFixture::class
        ];
    }
}