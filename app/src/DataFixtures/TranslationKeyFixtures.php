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
        'roleRightName@addTrack',
        'roleRightName@updateTrack',
        'roleRightName@deleteTrack',

        'common@titleIsRequired',
        'common@descriptionIsRequired',
        'common@priceIsRequired',
        'common@priceInvalid',
        'common@statusIsRequired',
        'common@statusInvalid',
        'common@subscriptionIsRequired',
        'common@titleTranslationKeyMaxLength',
        'common@invalidEmail',
        'common@userIsRequired',
        'common@userProfileIsRequired',
        'common@validToIsRequired',
        'common@emailMaxLength',

        'lang@codeExist',
        'lang@codeMinLength',
        'lang@codeMaxLength',
        'lang@titleMaxLength',

        'translationKey@keyExist',
        'translationKey@nameIsRequired',
        'translationKey@nameMaxLength',

        'translation@langIsRequired',
        'translation@keyIsRequired',
        'translation@translationIsRequired',

        'user@emailExist',
        'user@usernameExist',
        'user@invalidEmail',
        'user@usernameIsRequired',
        'user@usernameMaxLength',
        'user@passwordIsRequired',
        'user@passordMinLength',
        'user@passwordRegex',

        'userProfile@nameIsRequired',
        'userProfile@surnameMaxLength',
        'userProfile@patronymicMaxLength',
        'userProfile@invalidBirth',

        'subscription@nameIsRequired',
        'subscription@nameMaxLength',
        'subscription@descriptionMaxLength',

        'subscriptionRightName@keyExist',
        'subscriptionRightName@keyIsRequired',
        'subscriptionRightName@keyMaxLength',

        'subscriptionRight@rightNameIsRequired',
        'subscriptionRight@rightNameIsRequired',

        'userSubscription@invalidValidTo',

        'user@emailExist',
        'user@usernameExist',
        'user@usernameIsRequired',
        'user@usernameMaxLength',
        'user@passwordIsRequired',
        'user@passordMinLength',
        'user@passwordRegex',
        'user@roleIsRequired',

        'userProfile@nameIsRequired',
        'userProfile@nameMaxLength',
        'userProfile@surnameMaxLength',
        'userProfile@patronymicMaxLength',
        'userProfile@invalidBirth',

        'userProfileCover@coverIsRequired',

        'userProfilePhoto@photoIsRequired',
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
