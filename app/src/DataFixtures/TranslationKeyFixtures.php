<?php

namespace App\DataFixtures;

use App\Entity\TranslationKey;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TranslationKeyFixtures
 *
 * @package Aoo\DataFixtures
 *
 * @author  Codememory
 */
class TranslationKeyFixtures extends Fixture
{

    /**
     * @var array
     */
    private array $keys = [
        'role@user',
        'role@developer',
        'role@admin',
        'role@support',
        'role@musicManager',

        'rolePermission@addTrack',
        'rolePermission@updateTrack',
        'rolePermission@deleteTrack',

        'common@titleIsRequired',
        'common@descriptionIsRequired',
        'common@priceIsRequired',
        'common@priceIsInvalid',
        'common@statusIsRequired',
        'common@invalidStatus',
        'common@subscriptionIsRequired',
        'common@titleTranslationKeyMaxLength',
        'common@invalidEmail',
        'common@userIsRequired',
        'common@userProfileIsRequired',
        'common@validToIsRequired',
        'common@emailMaxLength',
        'common@imageIsRequired',
        'common@priceInvalid',
        'common@statusInvalid',
        'common@titleTranslationKeyNotExist',
        'common@descriptionTranslationKeyNotExist',
        'common@accessDenied',
        'common@authRequired',

        'lang@codeExist',
        'lang@langNotExist',
        'lang@codeMinLength',
        'lang@codeMaxLength',
        'lang@titleMaxLength',
        'lang@successCreate',
        'lang@successUpdate',
        'lang@successDelete',

        'translationKey@keyExist',
        'translationKey@nameIsRequired',
        'translationKey@nameMaxLength',
        'translationKey@notExist',
        'translationKey@successCreate',
        'translationKey@successUpdate',
        'translationKey@successDelete',

        'translation@langNotExistOrNotEntered',
        'translation@keyNotExistOrNotEnetred',
        'translation@translationIsRequired',
        'translation@exist',
        'translation@notExist',
        'translation@successAdd',
        'translation@successDelete',
        'translation@successUpdate',

        'user@emailExist',
        'user@usernameExist',
        'user@usernameIsRequired',
        'user@usernameMaxLength',
        'user@passwordIsRequired',
        'user@passwordMinLength',
        'user@passwordRegex',
        'user@roleIsRequired',
        'user@successRegister',
        'user@invalidPasswordConfirm',
        'user@passwordConfirmIsRequired',
        'user@failedToIdentityUser',
        'user@passwordIsIncorrect',
        'user@accountNotActive',
        'user@successAuth',

        'userProfile@nameIsRequired',
        'userProfile@surnameMaxLength',
        'userProfile@patronymicMaxLength',
        'userProfile@invalidBirth',

        'subscription@nameIsRequired',
        'subscription@nameMaxLength',
        'subscription@descriptionMaxLength',
        'subscription@successCreate',
        'subscription@successUpdate',
        'subscription@successDelete',
        'subscription@notExist',

        'subscriptionPermissionName@keyExist',
        'subscriptionPermissionName@keyIsRequired',
        'subscriptionPermissionName@keyMaxLength',
        'subscriptionPermissionName@successCreate',
        'subscriptionPermissionName@successUpdate',
        'subscriptionPermissionName@successDelete',
        'subscriptionPermissionName@notExist',

        'subscriptionPermission@permissionNameNotExistOrNotEntered',
        'subscriptionPermission@subscriptionNotExistOrNotEnetred',
        'subscriptionPermission@rightNameIsRequired',
        'subscriptionPermission@successCreate',
        'subscriptionPermission@successUpdate',
        'subscriptionPermission@successDelete',
        'subscriptionPermission@notExist',
        'subscriptionPermission@exist',

        'userActivationAccount@tokenIsNotValid',
        'userActivationAccount@tokenNotExist',
        'userActivationAccount@successActivation',

        'albumType@notExist',
        'albumType@keyExist',
        'albumType@successCreate',
        'albumType@successUpdate',
        'albumType@successDelete',
    ];

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        foreach ($this->keys as $key) {
            $translationKeyEntity = new TranslationKey();

            $translationKeyEntity->setName($key);

            $this->addReference(sprintf('key-%s', $key), $translationKeyEntity);

            $manager->persist($translationKeyEntity);
        }

        $manager->flush();

    }

}
