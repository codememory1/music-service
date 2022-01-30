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

        'translation@langIsRequired',
        'translation@keyIsRequired',
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

        'subscriptionRight@rightNameIsRequired'
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
