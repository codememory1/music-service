<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\TranslationKeyFactory;
use App\Entity\TranslationKey;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class TranslationKeyDataFixture.
 *
 * @package App\DataFixtures
 * @template-extends AbstractDataFixture<TranslationKey>
 *
 * @author  Codememory
 */
final class TranslationKeyDataFixture extends AbstractDataFixture
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new TranslationKeyFactory('common@incorrectEmail'),
            new TranslationKeyFactory('common@passwordIsRequired'),
            new TranslationKeyFactory('common@incorrectPassword'),
            new TranslationKeyFactory('common@dataOutput'),
            new TranslationKeyFactory('common@invalidRefreshToken'),
            new TranslationKeyFactory('common@refreshTokenIsRequired'),
            new TranslationKeyFactory('common@failedToUpdateAccessToken'),
            new TranslationKeyFactory('common@incorrectPasswordBySchema'),
            new TranslationKeyFactory('common@minPasswordLength'),
            new TranslationKeyFactory('common@invalidConfirmPassword'),
            new TranslationKeyFactory('common@invalidCode'),
            new TranslationKeyFactory('common@titleTranslationKeyNotExist'),
            new TranslationKeyFactory('common@shortDescriptionTranslationKeyNotExist'),
            new TranslationKeyFactory('common@invalidOldPrice'),
            new TranslationKeyFactory('common@invalidPrice'),
            new TranslationKeyFactory('common@bannedDomainMail'),

            new TranslationKeyFactory('entityNotFound@page'),
            new TranslationKeyFactory('entityNotFound@language'),
            new TranslationKeyFactory('entityNotFound@translationKey'),
            new TranslationKeyFactory('entityNotFound@translation'),
            new TranslationKeyFactory('entityNotFound@permissionKey'),
            new TranslationKeyFactory('entityNotFound@role'),
            new TranslationKeyFactory('entityNotFound@subscription'),
            new TranslationKeyFactory('entityNotFound@albumType'),

            new TranslationKeyFactory('entityExist@oneOfPermissionExistToRole'),
            new TranslationKeyFactory('entityExist@subscriptionPermissionKey'),
            new TranslationKeyFactory('entityExist@subscription'),
            new TranslationKeyFactory('entityExist@translationKey'),
            new TranslationKeyFactory('entityExist@albumType'),

            new TranslationKeyFactory('auth@successAuthorization'),
            new TranslationKeyFactory('auth@authRequired'),
            new TranslationKeyFactory('auth@authNotRequired'),

            new TranslationKeyFactory('registration@successRegistration'),
            new TranslationKeyFactory('registration@registration'),

            new TranslationKeyFactory('userProfile@pseudonymIsRequired'),
            new TranslationKeyFactory('userProfile@maxPseudonymLength'),

            new TranslationKeyFactory('language@minCodeLength'),
            new TranslationKeyFactory('language@maxCodeLength'),
            new TranslationKeyFactory('language@originalTitleIsRequired'),
            new TranslationKeyFactory('language@successCreate'),
            new TranslationKeyFactory('language@successUpdate'),
            new TranslationKeyFactory('language@successDelete'),
            new TranslationKeyFactory('language@codeExist'),

            new TranslationKeyFactory('user@existByEmail'),

            new TranslationKeyFactory('userProfile@existByUser'),

            new TranslationKeyFactory('rolePermission@viewLanguagesWithFUllInfo'),
            new TranslationKeyFactory('rolePermission@createLanguage'),
            new TranslationKeyFactory('rolePermission@updateLanguage'),
            new TranslationKeyFactory('rolePermission@deleteLanguage'),
            new TranslationKeyFactory('rolePermission@showRoles'),
            new TranslationKeyFactory('rolePermission@createUserRole'),
            new TranslationKeyFactory('rolePermission@updateUserRole'),
            new TranslationKeyFactory('rolePermission@deleteUserRole'),
            new TranslationKeyFactory('rolePermission@updatePermissionsToRole'),
            new TranslationKeyFactory('rolePermission@showFullInfoSubscriptions'),
            new TranslationKeyFactory('rolePermission@createSubscription'),
            new TranslationKeyFactory('rolePermission@updateSubscription'),
            new TranslationKeyFactory('rolePermission@deleteSubscription'),
            new TranslationKeyFactory('rolePermission@showFullInfoTranslations'),
            new TranslationKeyFactory('rolePermission@createTranslation'),
            new TranslationKeyFactory('rolePermission@updateTranslation'),
            new TranslationKeyFactory('rolePermission@deleteTranslation'),
            new TranslationKeyFactory('rolePermission@showFullInfoAlbumTypes'),
            new TranslationKeyFactory('rolePermission@createAlbumType'),
            new TranslationKeyFactory('rolePermission@updateAlbumType'),
            new TranslationKeyFactory('rolePermission@deleteAlbumType'),

            new TranslationKeyFactory('role@developer'),
            new TranslationKeyFactory('role@developerDescription'),
            new TranslationKeyFactory('role@keyIsRequired'),
            new TranslationKeyFactory('role@titleIsRequired'),
            new TranslationKeyFactory('role@exist'),
            new TranslationKeyFactory('role@successCreate'),
            new TranslationKeyFactory('role@successUpdate'),
            new TranslationKeyFactory('role@successDelete'),

            new TranslationKeyFactory('user@failedToIdentify'),

            new TranslationKeyFactory('token@successUpdate'),

            new TranslationKeyFactory('logout@successLogout'),
            new TranslationKeyFactory('logout@failedToLogout'),

            new TranslationKeyFactory('accessDenied@notEnoughPermissions'),

            new TranslationKeyFactory('passwordReset@successSendRequestRestoration'),
            new TranslationKeyFactory('passwordReset@requestRestoration'),
            new TranslationKeyFactory('passwordReset@successRestorePassword'),

            new TranslationKeyFactory('accountActivation@successActivate'),

            new TranslationKeyFactory('rolePermission@successUpdatePermissionToRole'),

            new TranslationKeyFactory('subscription@keyIsRequired'),
            new TranslationKeyFactory('subscription@titleIsRequired'),
            new TranslationKeyFactory('subscription@descriptionIsRequired'),
            new TranslationKeyFactory('subscription@priceIsRequired'),
            new TranslationKeyFactory('subscription@statusIsRequired'),
            new TranslationKeyFactory('subscription@successCreate'),
            new TranslationKeyFactory('subscription@successUpdate'),
            new TranslationKeyFactory('subscription@successDelete'),
            new TranslationKeyFactory('subscription@premium'),
            new TranslationKeyFactory('subscription@premiumDescription'),
            new TranslationKeyFactory('subscription@artist'),
            new TranslationKeyFactory('subscription@artistDescription'),
            new TranslationKeyFactory('subscription@family'),
            new TranslationKeyFactory('subscription@familyDescription'),

            new TranslationKeyFactory('subscriptionPermissionKey@createAlbum'),

            new TranslationKeyFactory('translation@keyIsRequired'),
            new TranslationKeyFactory('translation@translationIsRequired'),
            new TranslationKeyFactory('translation@languageIsRequired'),
            new TranslationKeyFactory('translation@successCreate'),
            new TranslationKeyFactory('translation@successUpdate'),
            new TranslationKeyFactory('translation@successDelete'),

            new TranslationKeyFactory('albumType@keyIsRequired'),
            new TranslationKeyFactory('albumType@titleIsRequired'),
            new TranslationKeyFactory('albumType@successCreate'),
            new TranslationKeyFactory('albumType@successUpdate'),
            new TranslationKeyFactory('albumType@successDelete'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("tk-{$entity->getKey()}", $entity);
        }

        $manager->flush();
    }
}