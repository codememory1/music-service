<?php

namespace App\DataFixtures;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class LanguageTranslationFixtures
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
class TranslationFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @var array
     */
    private array $translations = [
        // RU - role
        [
            'lang'        => 'ru',
            'key'         => 'role@user',
            'translation' => 'Пользователь'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'role@developer',
            'translation' => 'Разработчик'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'role@admin',
            'translation' => 'Администратор'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'role@support',
            'translation' => 'Поддержка'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'role@musicManager',
            'translation' => 'Менеджер по загрузке музыки'
        ],

        // RU - roleRightName
        [
            'lang'        => 'ru',
            'key'         => 'roleRightName@addTrack',
            'translation' => 'Добавление музыки'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'roleRightName@updateTrack',
            'translation' => 'Обновление музыки'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'roleRightName@deleteTrack',
            'translation' => 'Удаление музыки'
        ],

        // RU - Common
        [
            'lang'        => 'ru',
            'key'         => 'common@titleIsRequired',
            'translation' => 'Название трека обязательно к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@descriptionIsRequired',
            'translation' => 'Описание трека обязательно к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@priceIsRequired',
            'translation' => 'Цена обязательна к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@priceIsInvalid',
            'translation' => 'Некорректно указана цена'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@statusIsRequired',
            'translation' => 'Статус обязателен к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@invalidStatus',
            'translation' => 'Некорректный статус'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@subscriptionIsRequired',
            'translation' => 'Подписка обязательна к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@titleTranslationKeyMaxLength',
            'translation' => 'Ключ перевода названия не должен превышать 255 символов'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@invalidEmail',
            'translation' => 'Некорректный формат электронной почты'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@userIsRequired',
            'translation' => 'Пользователь обязателен к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@userProfileIsRequired',
            'translation' => 'Профиль пользователя обязателен к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@validToIsRequired',
            'translation' => 'Поле "действителнный" обязательно к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@emailMaxLength',
            'translation' => 'Длина не должна превышать 255 символов'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'common@imageIsRequired',
            'translation' => 'Изображение обязательно к заполнению'
        ],

        // RU - lang
        [
            'lang'        => 'ru',
            'key'         => 'lang@codeExist',
            'translation' => 'Данный код языка уже существует'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'lang@langNotExist',
            'translation' => 'Данный код языка не существует'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'lang@codeMinLength',
            'translation' => 'Код языка должен состоять не меньше чем из 2-х символов'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'lang@codeMaxLength',
            'translation' => 'Код языка не должен превышать 3-х символов'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'lang@titleMaxLength',
            'translation' => 'Название языка не должно превышать 255 символов'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'lang@successCreate',
            'translation' => 'Язык успешно создан'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'lang@successUpdate',
            'translation' => 'Язык успешно обновлен'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'lang@successDelete',
            'translation' => 'Язык успешно удален'
        ],

        // RU - translationKey
        [
            'lang'        => 'ru',
            'key'         => 'translationKey@keyExist',
            'translation' => 'Данный ключ перевода уже существует'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'translationKey@nameIsRequired',
            'translation' => 'Ключ обязателен к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'translationKey@nameMaxLength',
            'translation' => 'Длина ключа не должна превышать 255 символов'
        ],

        // RU - translation
        [
            'lang'        => 'ru',
            'key'         => 'translation@langIsRequired',
            'translation' => 'Язык перевода обязателен к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'translation@keyIsRequired',
            'translation' => 'Ключ перевода обязателен к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'translation@translationIsRequired',
            'translation' => 'Перевод обязателен к заполнению'
        ],

        // RU - user
        [
            'lang'        => 'ru',
            'key'         => 'user@emailExist',
            'translation' => 'Пользователь с данной почтой уже существует'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'user@usernameExist',
            'translation' => 'Имя пользователя уже существует'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'user@usernameIsRequired',
            'translation' => 'Имя пользователя обязательно к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'user@usernameMaxLength',
            'translation' => 'Имя пользователя не должно превышать 250 символов'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'user@passwordIsRequired',
            'translation' => 'Пароль обязателен к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'user@passwordMinLength',
            'translation' => 'Пароль должен состоять не меньше чем из 8 символов'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'user@passwordRegex',
            'translation' => 'Пароль должен состоять из букв, цифр и спец., символов'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'user@roleIsRequired',
            'translation' => 'Роль обязательна к заполнению'
        ],

        // RU - userProfile
        [
            'lang'        => 'ru',
            'key'         => 'userProfile@nameIsRequired',
            'translation' => 'Имя обязательно к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'userProfile@surnameMaxLength',
            'translation' => 'Фамилия не должна первышать 50-ти символов'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'userProfile@patronymicMaxLength',
            'translation' => 'Отчество не должно первышать 50-ти символов'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'userProfile@invalidBirth',
            'translation' => 'Некорректная дата рождения'
        ],

        // RU - Subscription
        [
            'lang'        => 'ru',
            'key'         => 'subscription@nameIsRequired',
            'translation' => 'Имя подписки обязательно к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'subscription@nameMaxLength',
            'translation' => 'Имя не должно превышать 255 символов'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'subscription@descriptionMaxLength',
            'translation' => 'Описание не должно превышать 255 символов'
        ],

        // RU - subscriptionRightName
        [
            'lang'        => 'ru',
            'key'         => 'subscriptionRightName@keyExist',
            'translation' => 'Данный ключ уже существует'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'subscriptionRightName@keyIsRequired',
            'translation' => 'Ключ обязательный к заполнению'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'subscriptionRightName@keyMaxLength',
            'translation' => 'Длина ключа не должна превышать 255 символов'
        ],

        // RU - subscriptionRight
        [
            'lang'        => 'ru',
            'key'         => 'subscriptionRight@rightNameIsRequired',
            'translation' => 'Ключ право обязательный к заполнению'
        ]
    ];

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        foreach ($this->translations as $translation) {
            /** @var Language $languageEntity */
            $languageEntity = $this->getReference(sprintf('lang-%s', $translation['lang']));

            /** @var TranslationKey $translationKey */
            $translationKey = $this->getReference(sprintf('key-%s', $translation['key']));
            $translationEntity = new Translation();

            $translationEntity
                ->setLang($languageEntity)
                ->setTranslationKey($translationKey)
                ->setTranslation($translation['translation']);

            $manager->persist($translationEntity);
        }

        $manager->flush();

    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {

        return [
            LanguageFixtures::class,
            TranslationKeyFixtures::class
        ];

    }

}
