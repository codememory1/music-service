<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\RolePermissionKeyFactory;
use App\Entity\RolePermissionKey;
use App\Enum\RolePermissionEnum;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataFixture<RolePermissionKey>
 */
final class RolePermissionKeyDataFixture extends AbstractDataFixture implements DependentFixtureInterface, FixtureGroupInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new RolePermissionKeyFactory(RolePermissionEnum::VIEW_LANGUAGES_WITH_FULL_INFO, 'rolePermission@viewLanguagesWithFUllInfo'),
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_LANGUAGE, 'rolePermission@createLanguage'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_LANGUAGE, 'rolePermission@updateLanguage'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_LANGUAGE, 'rolePermission@deleteLanguage'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_ROLES, 'rolePermission@showRoles'),
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_USER_ROLE, 'rolePermission@createUserRole'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_USER_ROLE, 'rolePermission@updateUserRole'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_USER_ROLE, 'rolePermission@deleteUserRole'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_PERMISSIONS_TO_ROLE, 'rolePermission@updatePermissionsToRole'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS, 'rolePermission@showFullInfoSubscription'),
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_SUBSCRIPTION, 'rolePermission@createSubscription'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_SUBSCRIPTION, 'rolePermission@updateSubscription'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_SUBSCRIPTION, 'rolePermission@deleteSubscription'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS, 'rolePermission@showFullInfoTranslations'),
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_TRANSLATION, 'rolePermission@createTranslation'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_TRANSLATION, 'rolePermission@updateTranslation'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_TRANSLATION, 'rolePermission@deleteTranslation'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_FULL_INFO_ALBUM_TYPES, 'rolePermission@showFullInfoAlbumTypes'),
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_ALBUM_TYPE, 'rolePermission@createAlbumType'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_ALBUM_TYPE, 'rolePermission@updateAlbumType'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_ALBUM_TYPE, 'rolePermission@deleteAlbumType'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_FULL_INFO_ALBUMS, 'rolePermission@showFullInfoAlbums'),
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_ALBUM_TO_USER, 'rolePermission@createAlbumToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_ALBUM_TO_USER, 'rolePermission@updateAlbumToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_ALBUM_TO_USER, 'rolePermission@deleteAlbumToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_USER_SESSION_TO_USER, 'rolePermission@deleteUserSessionToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION, 'rolePermission@showInfoAboutUserSession'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_USER_SESSION_TOKEN_TO_USER, 'rolePermission@showInfoAboutUserSession'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_USER_SESSIONS, 'rolePermission@showUserSessions'),
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_NOTIFICATION, 'rolePermission@createNotifications'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_FULL_INFO_MULTIMEDIA_CATEGORIES, 'rolePermission@showFullInfoMultimediaCategories'),
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_MULTIMEDIA_CATEGORY, 'rolePermission@createMultimediaCategory'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_MULTIMEDIA_CATEGORY, 'rolePermission@updateMultimediaCategory'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_MULTIMEDIA_CATEGORY, 'rolePermission@deleteMultimediaCategory'),
            new RolePermissionKeyFactory(RolePermissionEnum::MULTIMEDIA_STATUS_CONTROL_TO_USER, 'rolePermission@multimediaStatusControlToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA, 'rolePermission@showAllUserMultimedia'),
            new RolePermissionKeyFactory(RolePermissionEnum::ADD_MULTIMEDIA_TO_USER, 'rolePermission@addMultimediaToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_MULTIMEDIA_TO_USER, 'rolePermission@updateMultimediaToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_MULTIMEDIA_TO_USER, 'rolePermission@deleteMultimediaToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::ALBUM_STATUS_CONTROL_TO_USER, 'rolePermission@albumStatusControlToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_MEDIA_LIBRARY_TO_USER, 'rolePermission@createMediaLibraryToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_MEDIA_LIBRARY_TO_USER, 'rolePermission@updateMediaLibraryToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_MEDIA_LIBRARY_TO_USER, 'rolePermission@showMediaLibraryToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER, 'rolePermission@deleteMultimediaMediaLibraryToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER, 'rolePermission@updateMultimediaFromMediaLibraryToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_USER_PLAYLISTS, 'rolePermission@showUserPlaylists'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_FULL_INFO_USER_PLAYLISTS, 'rolePermission@showFullInfoUserPlaylist'),
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_PLAYLIST_TO_USER, 'rolePermission@createPlaylistToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_PLAYLIST_TO_USER, 'rolePermission@updatePlaylistToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_PLAYLIST_TO_USER, 'rolePermission@deletePlaylistToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_PLAYLIST_DIRECTORIES_TO_USER, 'rolePermission@showPlaylistDirectoriesToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_FULL_INFO_PLAYLIST_DIRECTORIES_TO_USER, 'rolePermission@showFullInfoPlaylistDirectoriesToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_PLAYLIST_DIRECTORY_TO_USER, 'rolePermission@createPlaylistDirectoryToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_PLAYLIST_DIRECTORY_TO_USER, 'rolePermission@updatePlaylistDirectoryToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_PLAYLIST_DIRECTORY_TO_USER, 'rolePermission@deletePlaylistDirectoryToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::ADD_MULTIMEDIA_TO_PLAYLIST_DIRECTORY, 'rolePermission@addMultimediaToPlaylistDirectory'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_MULTIMEDIA_TO_PLAYLIST_DIRECTORY, 'rolePermission@deleteMultimediaToPlaylistDirectory'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_USER_PROFILE_DESIGN, 'rolePermission@updateUserProfileDesign'),
            new RolePermissionKeyFactory(RolePermissionEnum::ADD_FRIEND_TO_USER, 'rolePermission@addFriendToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_FRIEND_TO_USER, 'rolePermission@deleteFriendToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_MULTIMEDIA_STATISTICS_TO_USER, 'rolePermission@showMultimediaStatisticsToUser'),

            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_ALL_BRANCHES, 'rolePermission@showAllBranch'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_BRANCH, 'rolePermission@updateBranch'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_DATA_BRANCH, 'rolePermission@updateDataBranch'),
            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_DATA_BRANCH, 'rolePermission@showDataBranch'),

            new RolePermissionKeyFactory(RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA_EXTERNAL_SERVICE, 'rolePermission@showAllUserMultimediaExternalService'),
            new RolePermissionKeyFactory(RolePermissionEnum::ADD_MULTIMEDIA_EXTERNAL_SERVICE_TO_USER, 'rolePermission@addMultimediaExternalServiceToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::UPDATE_MULTIMEDIA_EXTERNAL_SERVICE_TO_USER, 'rolePermission@updateMultimediaExternalServiceToUser'),
            new RolePermissionKeyFactory(RolePermissionEnum::DELETE_MULTIMEDIA_EXTERNAL_SERVICE_TO_USER, 'rolePermission@deleteMultimediaExternalServiceToUser'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("rpk-{$entity->getKey()}", $entity);
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

    /**
     * @inheritDoc
     */
    public static function getGroups(): array
    {
        return [
            'user'
        ];
    }
}