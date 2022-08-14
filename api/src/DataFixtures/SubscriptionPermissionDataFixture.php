<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\SubscriptionPermissionFactory;
use App\Entity\SubscriptionPermission;
use App\Enum\SubscriptionEnum;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataFixture<SubscriptionPermission>
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
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::SHOW_MY_MULTIMEDIA),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::ADD_MULTIMEDIA),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::UPDATE_MULTIMEDIA),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::DELETE_MULTIMEDIA),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::CONTROL_SUBSCRIPTION_ON_ARTIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::ACCEPTING_SUBSCRIBERS),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::ADD_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::CREATE_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::UPDATE_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::DELETE_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::SHOW_MY_PLAYLIST_DIRECTORIES),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::DELETE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::UPDATE_PROFILE_DESIGN),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::SHOW_MY_FRIENDS),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::ADD_AS_FRIEND),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::DELETE_FRIEND),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::SHARE_MEDIA_LIBRARY_WITH_FRIENDS),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT),
            new SubscriptionPermissionFactory(SubscriptionEnum::ARTIST, SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT),

            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::CONTROL_SUBSCRIPTION_ON_ARTIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::ADD_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::CREATE_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::UPDATE_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::DELETE_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::SHOW_MY_PLAYLIST_DIRECTORIES),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::DELETE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::SHOW_MY_FRIENDS),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::ADD_AS_FRIEND),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::DELETE_FRIEND),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::SHARE_MEDIA_LIBRARY_WITH_FRIENDS),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT),
            new SubscriptionPermissionFactory(SubscriptionEnum::PREMIUM, SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT),

            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::CONTROL_SUBSCRIPTION_ON_ARTIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::ADD_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::CREATE_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::UPDATE_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::DELETE_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::SHOW_MY_PLAYLIST_DIRECTORIES),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::DELETE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::SHOW_MY_FRIENDS),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::ADD_AS_FRIEND),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::DELETE_FRIEND),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::SHARE_MEDIA_LIBRARY_WITH_FRIENDS),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT),
            new SubscriptionPermissionFactory(SubscriptionEnum::FAMILY, SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT),
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