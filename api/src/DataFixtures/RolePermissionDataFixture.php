<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\RolePermissionFactory;
use App\Entity\RolePermission;
use App\Enum\RoleEnum;
use App\Enum\RolePermissionEnum;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class RolePermissionDataFixture.
 *
 * @package App\DataFixtures
 * @template-extends AbstractDataFixture<RolePermission>
 *
 * @author  Codememory
 */
final class RolePermissionDataFixture extends AbstractDataFixture implements DependentFixtureInterface, FixtureGroupInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::VIEW_LANGUAGES_WITH_FULL_INFO),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_LANGUAGE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_LANGUAGE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_LANGUAGE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_ROLES),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_USER_ROLE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_USER_ROLE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_USER_ROLE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_PERMISSIONS_TO_ROLE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_SUBSCRIPTION),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_SUBSCRIPTION),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_SUBSCRIPTION),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_TRANSLATION),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_TRANSLATION),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_TRANSLATION),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_FULL_INFO_ALBUM_TYPES),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_ALBUM_TYPE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_ALBUM_TYPE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_ALBUM_TYPE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_FULL_INFO_ALBUMS),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_ALBUM_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_ALBUM_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_ALBUM_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_USER_SESSION_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_USER_SESSION_TOKEN_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_USER_SESSIONS),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_NOTIFICATION),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_FULL_INFO_MULTIMEDIA_CATEGORIES),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_MULTIMEDIA_CATEGORY),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_MULTIMEDIA_CATEGORY),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_MULTIMEDIA_CATEGORY),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::MULTIMEDIA_STATUS_CONTROL_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::ADD_MULTIMEDIA_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_MULTIMEDIA_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_MULTIMEDIA_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::ALBUM_STATUS_CONTROL_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_MEDIA_LIBRARY_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_MEDIA_LIBRARY_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_MEDIA_LIBRARY_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_USER_PLAYLISTS),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_FULL_INFO_USER_PLAYLISTS),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_PLAYLIST_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_PLAYLIST_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_PLAYLIST_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_PLAYLIST_DIRECTORIES_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_FULL_INFO_PLAYLIST_DIRECTORIES_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_PLAYLIST_DIRECTORY_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_PLAYLIST_DIRECTORY_TO_USER),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_PLAYLIST_DIRECTORY_TO_USER),
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
            RoleDataFixture::class,
            RolePermissionKeyDataFixture::class
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