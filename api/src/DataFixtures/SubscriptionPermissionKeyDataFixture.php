<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\SubscriptionPermissionKeyFactory;
use App\Entity\SubscriptionPermissionKey;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataFixture<SubscriptionPermissionKey>
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
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::CONTROL_SUBSCRIPTION_ON_ARTIST, 'subscriptionPermissionKey@controlSubscriptionOnArtist'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::ACCEPTING_SUBSCRIBERS, 'subscriptionPermissionKey@acceptingSubscribers'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::ADD_MULTIMEDIA_TO_MEDIA_LIBRARY, 'subscriptionPermissionKey@addMultimediaToMediaLibrary'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY, 'subscriptionPermissionKey@updateMultimediaFromMediaLibrary'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY, 'subscriptionPermissionKey@deleteMultimediaFromMediaLibrary'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::CREATE_PLAYLIST, 'subscriptionPermissionKey@createPlaylist'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::UPDATE_PLAYLIST, 'subscriptionPermissionKey@updatePlaylist'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::DELETE_PLAYLIST, 'subscriptionPermissionKey@deletePlaylist'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS, 'subscriptionPermissionKey@showMyPlaylists'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::SHOW_MY_PLAYLIST_DIRECTORIES, 'subscriptionPermissionKey@showMyPlaylistDirectories'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST, 'subscriptionPermissionKey@createDirectoryToPlaylist'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST, 'subscriptionPermissionKey@updateDirectoryToPlaylist'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::DELETE_DIRECTORY_TO_PLAYLIST, 'subscriptionPermissionKey@deleteDirectoryToPlaylist'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::UPDATE_PROFILE_DESIGN, 'subscriptionPermissionKey@updateProfileDesign'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::SHOW_MY_FRIENDS, 'subscriptionPermissionKey@showMyFriends'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::ADD_AS_FRIEND, 'subscriptionPermissionKey@addAsFriend'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::DELETE_FRIEND, 'subscriptionPermissionKey@deleteFriend'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS, 'subscriptionPermissionKey@shareMultimediaWithFriends'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::SHARE_MEDIA_LIBRARY_WITH_FRIENDS, 'subscriptionPermissionKey@shareMediaLibraryWithFriends'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT, 'subscriptionPermissionKey@controlMultimediaMediaLibraryEvent'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT, 'subscriptionPermissionKey@controlMediaLibraryEvent'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::ADD_TIME_CODE_TO_MULTIMEDIA, 'subscriptionPermissionKey@addTimeCodeToMultimedia'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::UPDATE_TIME_CODE_TO_MULTIMEDIA, 'subscriptionPermissionKey@updateTimeCodeToMultimedia'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::DELETE_TIME_CODE_TO_MULTIMEDIA, 'subscriptionPermissionKey@deleteTimeCodeToMultimedia'),
            new SubscriptionPermissionKeyFactory(SubscriptionPermissionEnum::SHOW_MULTIMEDIA_STATISTICS, 'subscriptionPermissionKey@showMultimediaStatistics'),
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