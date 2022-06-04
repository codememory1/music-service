<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\RolePermissionKeyFactory;
use App\Entity\RolePermissionKey;
use App\Enum\RolePermissionEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class RolePermissionKeyDataFixture.
 *
 * @package App\DataFixtures
 * @template-extends AbstractDataFixture<RolePermissionKey>
 *
 * @author  Codememory
 */
final class RolePermissionKeyDataFixture extends AbstractDataFixture implements DependentFixtureInterface
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
}