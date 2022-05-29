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

            new TranslationKeyFactory('entityNotFound@page'),
            new TranslationKeyFactory('entityNotFound@language'),
            new TranslationKeyFactory('entityNotFound@translationKey'),
            new TranslationKeyFactory('entityNotFound@translation'),
            new TranslationKeyFactory('entityNotFound@rolePermissionKey'),
            new TranslationKeyFactory('entityNotFound@role'),

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
            new TranslationKeyFactory('rolePermission@createUserRole'),
            new TranslationKeyFactory('rolePermission@updateUserRole'),
            new TranslationKeyFactory('rolePermission@deleteUserRole'),

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