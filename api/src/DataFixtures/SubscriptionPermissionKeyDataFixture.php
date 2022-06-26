<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\SubscriptionPermissionKeyFactory;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class SubscriptionPermissionKeyDataFixture.
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
final class SubscriptionPermissionKeyDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::SHOW_MY_ALBUMS, 'subscriptionPermissionKey@showMyAlbums'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::CREATE_ALBUM, 'subscriptionPermissionKey@createAlbum'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::UPDATE_ALBUM, 'subscriptionPermissionKey@updateAlbum'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::DELETE_ALBUM, 'subscriptionPermissionKey@deleteAlbum'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::SHOW_MY_MULTIMEDIA, 'subscriptionPermissionKey@showMyMultimedia'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::ADD_MULTIMEDIA, 'subscriptionPermissionKey@addMultimedia'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA, 'subscriptionPermissionKey@updateMultimedia'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::DELETE_MULTIMEDIA, 'subscriptionPermissionKey@deleteMultimedia'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA, 'subscriptionPermissionKey@listeningToMultimedia'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("spk-{$entity->getKey()}", $entity);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [
            TranslationDataFixture::class
        ];
    }
}