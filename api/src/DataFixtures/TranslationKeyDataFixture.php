<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\TranslationKeyFactory;
use App\Entity\TranslationKey;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
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
final class TranslationKeyDataFixture extends AbstractDataFixture implements FixtureGroupInterface
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
            new TranslationKeyFactory('common@uploadFileNotImage'),
            new TranslationKeyFactory('common@invalidStatus'),
            new TranslationKeyFactory('common@invalidSubtitles'),
            new TranslationKeyFactory('common@successAppealCanceled'),
            new TranslationKeyFactory('common@badAppealCanceled'),

            new TranslationKeyFactory('entityNotFound@page'),
            new TranslationKeyFactory('entityNotFound@language'),
            new TranslationKeyFactory('entityNotFound@translationKey'),
            new TranslationKeyFactory('entityNotFound@translation'),
            new TranslationKeyFactory('entityNotFound@permissionKey'),
            new TranslationKeyFactory('entityNotFound@role'),
            new TranslationKeyFactory('entityNotFound@subscription'),
            new TranslationKeyFactory('entityNotFound@albumType'),
            new TranslationKeyFactory('entityNotFound@user'),
            new TranslationKeyFactory('entityNotFound@album'),
            new TranslationKeyFactory('entityNotFound@userSession'),
            new TranslationKeyFactory('entityNotFound@multimediaCategory'),
            new TranslationKeyFactory('entityNotFound@performer'),
            new TranslationKeyFactory('entityNotFound@multimedia'),

            new TranslationKeyFactory('entityExist@oneOfPermissionExistToRole'),
            new TranslationKeyFactory('entityExist@subscriptionPermissionKey'),
            new TranslationKeyFactory('entityExist@subscription'),
            new TranslationKeyFactory('entityExist@translationKey'),
            new TranslationKeyFactory('entityExist@albumType'),

            new TranslationKeyFactory('auth@successAuthorization'),
            new TranslationKeyFactory('auth@authRequired'),
            new TranslationKeyFactory('auth@authNotRequired'),
            new TranslationKeyFactory('auth@authError'),

            new TranslationKeyFactory('registration@successRegistration'),
            new TranslationKeyFactory('registration@registration'),
            new TranslationKeyFactory('registration@didNotProvideData'),

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
            new TranslationKeyFactory('rolePermission@showFullInfoAlbums'),
            new TranslationKeyFactory('rolePermission@createAlbumToUser'),
            new TranslationKeyFactory('rolePermission@updateAlbumToUser'),
            new TranslationKeyFactory('rolePermission@deleteAlbumToUser'),
            new TranslationKeyFactory('rolePermission@deleteUserSessionToUser'),
            new TranslationKeyFactory('rolePermission@showInfoAboutUserSession'),
            new TranslationKeyFactory('rolePermission@showUserSessionTokensToUser'),
            new TranslationKeyFactory('rolePermission@showUserSessions'),
            new TranslationKeyFactory('rolePermission@createNotifications'),
            new TranslationKeyFactory('rolePermission@showFullInfoMultimediaCategories'),
            new TranslationKeyFactory('rolePermission@createMultimediaCategory'),
            new TranslationKeyFactory('rolePermission@updateMultimediaCategory'),
            new TranslationKeyFactory('rolePermission@deleteMultimediaCategory'),
            new TranslationKeyFactory('rolePermission@multimediaStatusControlToUser'),
            new TranslationKeyFactory('rolePermission@showAllUserMultimedia'),
            new TranslationKeyFactory('rolePermission@addMultimediaToUser'),
            new TranslationKeyFactory('rolePermission@updateMultimediaToUser'),
            new TranslationKeyFactory('rolePermission@deleteMultimediaToUser'),

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
            new TranslationKeyFactory('accessDenied@notSubscription'),
            new TranslationKeyFactory('accessDenied@notSubscriptionPermissions'),

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

            new TranslationKeyFactory('subscriptionPermissionKey@showMyAlbums'),
            new TranslationKeyFactory('subscriptionPermissionKey@createAlbum'),
            new TranslationKeyFactory('subscriptionPermissionKey@updateAlbum'),
            new TranslationKeyFactory('subscriptionPermissionKey@deleteAlbum'),
            new TranslationKeyFactory('subscriptionPermissionKey@showMyMultimedia'),
            new TranslationKeyFactory('subscriptionPermissionKey@addMultimedia'),
            new TranslationKeyFactory('subscriptionPermissionKey@updateMultimedia'),
            new TranslationKeyFactory('subscriptionPermissionKey@deleteMultimedia'),
            new TranslationKeyFactory('subscriptionPermissionKey@listeningToMultimedia'),

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
            new TranslationKeyFactory('albumType@remix'),
            new TranslationKeyFactory('albumType@double'),
            new TranslationKeyFactory('albumType@concert'),
            new TranslationKeyFactory('albumType@megnetic'),
            new TranslationKeyFactory('albumType@minion'),
            new TranslationKeyFactory('albumType@compilation'),
            new TranslationKeyFactory('albumType@bestCompilation'),
            new TranslationKeyFactory('albumType@single'),

            new TranslationKeyFactory('album@titleIsRequired'),
            new TranslationKeyFactory('album@maxTitleLength'),
            new TranslationKeyFactory('album@descriptionIsRequired'),
            new TranslationKeyFactory('album@maxDescriptionLength'),
            new TranslationKeyFactory('album@imageIsRequired'),
            new TranslationKeyFactory('album@maxSizeImage'),
            new TranslationKeyFactory('album@typeIsRequired'),
            new TranslationKeyFactory('album@successCreate'),
            new TranslationKeyFactory('album@successUpdate'),
            new TranslationKeyFactory('album@successDelete'),
            new TranslationKeyFactory('album@badAddMultimediaToSingleAlbum'),

            new TranslationKeyFactory('userSession@successDelete'),
            new TranslationKeyFactory('userSession@successDeleteMultiple'),

            new TranslationKeyFactory('notification@typeIsRequired'),
            new TranslationKeyFactory('notification@toIsRequired'),
            new TranslationKeyFactory('notification@titleIsRequired'),
            new TranslationKeyFactory('notification@maxLengthTitle'),
            new TranslationKeyFactory('notification@messageIsRequired'),
            new TranslationKeyFactory('notification@maxLengthMessage'),
            new TranslationKeyFactory('notification@invalidAction'),
            new TranslationKeyFactory('notification@successCreate'),

            new TranslationKeyFactory('serviceAuth@authorizationCodeIsRequired'),

            new TranslationKeyFactory('multimediaCategory@titleIsRequired'),
            new TranslationKeyFactory('multimediaCategory@successCreate'),
            new TranslationKeyFactory('multimediaCategory@successUpdate'),
            new TranslationKeyFactory('multimediaCategory@successDelete'),

            new TranslationKeyFactory('multimedia@typeIsRequired'),
            new TranslationKeyFactory('multimedia@albumIsRequired'),
            new TranslationKeyFactory('multimedia@titleIsRequired'),
            new TranslationKeyFactory('multimedia@titleMaxLength'),
            new TranslationKeyFactory('multimedia@descriptionMaxLength'),
            new TranslationKeyFactory('multimedia@categoryIsRequired'),
            new TranslationKeyFactory('multimedia@uploadFileIsNotSubtitles'),
            new TranslationKeyFactory('multimedia@isObsceneWordsIsRequired'),
            new TranslationKeyFactory('multimedia@previewIsRequired'),
            new TranslationKeyFactory('multimedia@maxSizePreview'),
            new TranslationKeyFactory('multimedia@uploadFileIsNotPreview'),
            new TranslationKeyFactory('multimedia@successAdd'),
            new TranslationKeyFactory('multimedia@invalidTrackMimeType'),
            new TranslationKeyFactory('multimedia@invalidClipMimeType'),
            new TranslationKeyFactory('multimedia@multimediaIsRequired'),
            new TranslationKeyFactory('multimedia@badSendOnModeration'),
            new TranslationKeyFactory('multimedia@successSendOnModeration'),
            new TranslationKeyFactory('multimedia@successUpdate'),
            new TranslationKeyFactory('multimedia@successDelete'),
            new TranslationKeyFactory('multimedia@badUpdateInStatus'),
            new TranslationKeyFactory('multimedia@successSendOnAppeal'),
            new TranslationKeyFactory('multimedia@badSendOnAppeal'),
            new TranslationKeyFactory('multimedia@badPublish'),
            new TranslationKeyFactory('multimedia@badUnpublish'),
            new TranslationKeyFactory('multimedia@successPublish'),
            new TranslationKeyFactory('multimedia@successUnpublish'),
            new TranslationKeyFactory('multimedia@badAddMultimediaToUserInvalidSubscription'),
            new TranslationKeyFactory('multimedia@successSetLike'),
            new TranslationKeyFactory('multimedia@successSetDislike'),
            new TranslationKeyFactory('multimedia@successDeleteLike'),
            new TranslationKeyFactory('multimedia@successDeleteDislike'),

            new TranslationKeyFactory('status@draft'),
            new TranslationKeyFactory('status@moderation'),
            new TranslationKeyFactory('status@published'),
            new TranslationKeyFactory('status@unpublished'),
            new TranslationKeyFactory('status@appeal'),
            new TranslationKeyFactory('status@appealCanceld'),
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

    /**
     * @inheritDoc
     */
    public static function getGroups(): array
    {
        return [
            'translation'
        ];
    }
}