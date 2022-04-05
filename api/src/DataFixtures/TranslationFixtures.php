<?php

namespace App\DataFixtures;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class LanguageTranslationFixtures.
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
            'lang' => 'ru',
            'key' => 'role@user',
            'translation' => 'Пользователь'
        ],
        [
            'lang' => 'ru',
            'key' => 'role@developer',
            'translation' => 'Разработчик'
        ],
        [
            'lang' => 'ru',
            'key' => 'role@admin',
            'translation' => 'Администратор'
        ],
        [
            'lang' => 'ru',
            'key' => 'role@support',
            'translation' => 'Поддержка'
        ],
        [
            'lang' => 'ru',
            'key' => 'role@musicManager',
            'translation' => 'Менеджер по загрузке музыки'
        ],

        // RU - rolePermission
        [
            'lang' => 'ru',
            'key' => 'rolePermission@addTrack',
            'translation' => 'Добавление музыки'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@updateTrack',
            'translation' => 'Обновление музыки'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@deleteTrack',
            'translation' => 'Удаление музыки'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@createSubscription',
            'translation' => 'Создание подписки'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@updateSubscription',
            'translation' => 'Обновление подписки'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@deleteSubscription',
            'translation' => 'Удаление подписки'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@createLang',
            'translation' => 'Создание языка'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@updateLang',
            'translation' => 'Обновление языка'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@deleteLang',
            'translation' => 'Удаление языка'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@createLangTranslation',
            'translation' => 'Создание перевода языка'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@updateLangTranslation',
            'translation' => 'Обновление перевода языка'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@deleteLangTranslation',
            'translation' => 'Удаление перевода языка'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@createAlbumCategory',
            'translation' => 'Создание категории альбома'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@updateAlbumCategory',
            'translation' => 'Обновление категории альбома'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@deleteAlbumCategory',
            'translation' => 'Удаление категории альбома'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@createAlbumType',
            'translation' => 'Создание типа альбома'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@updateAlbumType',
            'translation' => 'Обновление типа альбома'
        ],
        [
            'lang' => 'ru',
            'key' => 'rolePermission@deleteAlbumType',
            'translation' => 'Удаление типа альбома'
        ],

        // RU - Common
        [
            'lang' => 'ru',
            'key' => 'common@titleIsRequired',
            'translation' => 'Название обязательно к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@descriptionIsRequired',
            'translation' => 'Описание обязательно к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@priceIsRequired',
            'translation' => 'Цена обязательна к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@priceIsInvalid',
            'translation' => 'Некорректно указана цена'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@statusIsRequired',
            'translation' => 'Статус обязателен к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@invalidStatus',
            'translation' => 'Некорректный статус'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@subscriptionIsRequired',
            'translation' => 'Подписка обязательна к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@titleTranslationKeyMaxLength',
            'translation' => 'Ключ перевода названия не должен превышать 255 символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@invalidEmail',
            'translation' => 'Некорректный формат электронной почты'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@userIsRequired',
            'translation' => 'Пользователь обязателен к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@userProfileIsRequired',
            'translation' => 'Профиль пользователя обязателен к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@validToIsRequired',
            'translation' => 'Поле "действителнный" обязательно к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@emailMaxLength',
            'translation' => 'Длина не должна превышать 255 символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@imageIsRequired',
            'translation' => 'Изображение обязательно к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@priceInvalid',
            'translation' => 'Некорректная цена'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@statusInvalid',
            'translation' => 'Некорректный статус'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@titleTranslationKeyNotExist',
            'translation' => 'Ключ перевода названия не существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@descriptionTranslationKeyNotExist',
            'translation' => 'Ключ перевода описания не существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@accessIsDenied',
            'translation' => 'Доступ запрещен'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@notAuth',
            'translation' => 'Для выполнения данного действия, требуется авторизация'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@successRegister',
            'translation' => 'Регистрация прошла успешна! На почту отправлено сообщение с активацией аккаунта'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@successAuth',
            'translation' => 'Авторизация прошла успешно'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@dataOutput',
            'translation' => 'Получение информации'
        ],
        [
            'lang' => 'ru',
            'key' => 'common@loginIsRequired',
            'translation' => 'Логин обязателен к заполнению'
        ],

        // RU - lang
        [
            'lang' => 'ru',
            'key' => 'lang@codeExist',
            'translation' => 'Данный код языка уже существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'lang@langNotExist',
            'translation' => 'Данный код языка не существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'lang@codeMinLength',
            'translation' => 'Код языка должен состоять не меньше чем из 2-х символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'lang@codeMaxLength',
            'translation' => 'Код языка не должен превышать 3-х символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'lang@titleMaxLength',
            'translation' => 'Название языка не должно превышать 255 символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'lang@successCreate',
            'translation' => 'Язык успешно создан'
        ],
        [
            'lang' => 'ru',
            'key' => 'lang@successUpdate',
            'translation' => 'Язык успешно обновлен'
        ],
        [
            'lang' => 'ru',
            'key' => 'lang@successDelete',
            'translation' => 'Язык успешно удален'
        ],

        // RU - translationKey
        [
            'lang' => 'ru',
            'key' => 'translationKey@keyExist',
            'translation' => 'Данный ключ перевода уже существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'translationKey@nameIsRequired',
            'translation' => 'Ключ обязателен к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'translationKey@nameMaxLength',
            'translation' => 'Длина ключа не должна превышать 255 символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'translationKey@notExist',
            'translation' => 'Данный ключ перевода не существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'translationKey@successCreate',
            'translation' => 'Ключ успешно создан'
        ],
        [
            'lang' => 'ru',
            'key' => 'translationKey@successUpdate',
            'translation' => 'Ключ успешно обновлен'
        ],
        [
            'lang' => 'ru',
            'key' => 'translationKey@successDelete',
            'translation' => 'Ключ успешно удален'
        ],

        // RU - translation
        [
            'lang' => 'ru',
            'key' => 'translation@langNotExistOrNotEntered',
            'translation' => 'Язык не существует или поле не заполнено'
        ],
        [
            'lang' => 'ru',
            'key' => 'translation@keyNotExistOrNotEnetred',
            'translation' => 'Ключ перевода не существует или поле не заполнено'
        ],
        [
            'lang' => 'ru',
            'key' => 'translation@translationIsRequired',
            'translation' => 'Перевод обязателен к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'translation@exist',
            'translation' => 'Данный перевод для текущего языка уже существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'translation@notExist',
            'translation' => 'Перевод не найден'
        ],
        [
            'lang' => 'ru',
            'key' => 'translation@successAdd',
            'translation' => 'Перевод успешно добавлен'
        ],
        [
            'lang' => 'ru',
            'key' => 'translation@successDelete',
            'translation' => 'Перевод успешно удален'
        ],
        [
            'lang' => 'ru',
            'key' => 'translation@successUpdate',
            'translation' => 'Перевод успешно обновлен'
        ],

        // RU - user
        [
            'lang' => 'ru',
            'key' => 'user@emailExist',
            'translation' => 'Пользователь с данной почтой уже существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@usernameExist',
            'translation' => 'Имя пользователя уже существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@usernameIsRequired',
            'translation' => 'Имя пользователя обязательно к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@usernameMaxLength',
            'translation' => 'Имя пользователя не должно превышать 250 символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@passwordIsRequired',
            'translation' => 'Пароль обязателен к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@passwordMinLength',
            'translation' => 'Пароль должен состоять не меньше чем из 8 символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@passwordRegex',
            'translation' => 'Пароль должен состоять из букв, цифр и спец., символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@roleIsRequired',
            'translation' => 'Роль обязательна к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@invalidPasswordConfirm',
            'translation' => 'Некорректное подтверждение пароля'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@passwordConfirmIsRequired',
            'translation' => 'Подтверждение пароля обязательно к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@failedToIdentityUser',
            'translation' => 'Не удалось идентифицировать пользователя'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@passwordIsIncorrect',
            'translation' => 'Некорректный пароль'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@accountNotActive',
            'translation' => 'Аккаунт не активирован! Подтвердите почту'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@successAuth',
            'translation' => 'Авторизация прошла успешно'
        ],
        [
            'lang' => 'ru',
            'key' => 'user@notExist',
            'translation' => 'Пользователь не найден'
        ],

        // RU - userProfile
        [
            'lang' => 'ru',
            'key' => 'userProfile@nameIsRequired',
            'translation' => 'Имя обязательно к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'userProfile@surnameMaxLength',
            'translation' => 'Фамилия не должна первышать 50-ти символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'userProfile@patronymicMaxLength',
            'translation' => 'Отчество не должно первышать 50-ти символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'userProfile@invalidBirth',
            'translation' => 'Некорректная дата рождения'
        ],

        // RU - Subscription
        [
            'lang' => 'ru',
            'key' => 'subscription@nameIsRequired',
            'translation' => 'Имя подписки обязательно к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscription@nameMaxLength',
            'translation' => 'Имя не должно превышать 255 символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscription@descriptionMaxLength',
            'translation' => 'Описание не должно превышать 255 символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscription@successCreate',
            'translation' => 'Подписка успешно создана'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscription@successUpdate',
            'translation' => 'Подписка успешно обновлена'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscription@successDelete',
            'translation' => 'Подписка успешно удалена'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscription@notExist',
            'translation' => 'Подписка не найдена'
        ],

        // RU - subscriptionPermissionName
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermissionName@keyExist',
            'translation' => 'Данный ключ уже существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermissionName@keyIsRequired',
            'translation' => 'Ключ обязательный к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermissionName@keyMaxLength',
            'translation' => 'Длина ключа не должна превышать 255 символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermissionName@successCreate',
            'translation' => 'Ключ разрешения успешно создан'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermissionName@successUpdate',
            'translation' => 'Ключ разрешения успешно обновлен'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermissionName@successDelete',
            'translation' => 'Ключ разрешения успешно удален'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermissionName@notExist',
            'translation' => 'Ключ разрешения не найден'
        ],

        // RU - subscriptionPermission
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermission@permissionNameNotExistOrNotEntered',
            'translation' => 'Имя право не существует или поле не заполнено'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermission@subscriptionNotExistOrNotEnetred',
            'translation' => 'Подписка не существует или поле не заполнено'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermission@rightNameIsRequired',
            'translation' => 'Ключ право обязательный к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermission@successCreate',
            'translation' => 'Разрешение успешно создано'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermission@successUpdate',
            'translation' => 'Разрешение успешно обновлено'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermission@successDelete',
            'translation' => 'Разрешение успешно удалено'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermission@notExist',
            'translation' => 'Разрешение не найдено'
        ],
        [
            'lang' => 'ru',
            'key' => 'subscriptionPermission@exist',
            'translation' => 'Данное разрешение для текущей подписки уже существует'
        ],

        // RU - userActivationAccount
        [
            'lang' => 'ru',
            'key' => 'userActivationAccount@tokenIsNotValid',
            'translation' => 'Токен активации не валидный'
        ],
        [
            'lang' => 'ru',
            'key' => 'userActivationAccount@tokenNotExist',
            'translation' => 'Токен активации не существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'userActivationAccount@successActivation',
            'translation' => 'Аккаунт успешно активирован'
        ],

        // RU - albumType
        [
            'lang' => 'ru',
            'key' => 'albumType@notExist',
            'translation' => 'Тип альбома не существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'albumType@keyExist',
            'translation' => 'Данный тип альбома уже существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'albumType@successCreate',
            'translation' => 'Тип альбома успешно создан'
        ],
        [
            'lang' => 'ru',
            'key' => 'albumType@successUpdate',
            'translation' => 'Тип альбома успешно обновлен'
        ],
        [
            'lang' => 'ru',
            'key' => 'albumType@successDelete',
            'translation' => 'Тип альбома успешно удален'
        ],

        // RU - albumCategory
        [
            'lang' => 'ru',
            'key' => 'albumCategory@exist',
            'translation' => 'Данная категория альбома уже существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'albumCategory@notExist',
            'translation' => 'Данная категория альбома не существует'
        ],
        [
            'lang' => 'ru',
            'key' => 'albumCategory@successCreate',
            'translation' => 'Категория альбома успешно создана'
        ],
        [
            'lang' => 'ru',
            'key' => 'albumCategory@successUpdate',
            'translation' => 'Категория альбома успешно обновлена'
        ],
        [
            'lang' => 'ru',
            'key' => 'albumCategory@successDelete',
            'translation' => 'Категория альбома успешно удалена'
        ],

        // RU - album
        [
            'lang' => 'ru',
            'key' => 'album@titleIsRequired',
            'translation' => 'Название альбома обязательно к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@titleMaxLength',
            'translation' => 'Название альбома не должно превышать 255 символов'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@typeNotExistOrNotEntered',
            'translation' => 'Тип альбома не найден или поле не заполнено'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@categoryNotExistOrNotEntered',
            'translation' => 'Категория альбома не найдена или поле не заполнено'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@photoIsRequired',
            'translation' => 'Фотография альбома обязательно к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@photoMaxSize',
            'translation' => 'Максимальный размер фотографии не должен превышать 1024K'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@photoMimeTypes',
            'translation' => 'Загруженный файл не является картинкой'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@tagsIsRequired',
            'translation' => 'Тэги альбома обязательны к заполнению'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@maxTags',
            'translation' => 'Для альбома не должно быть указано более 255 тэгов'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@successCreate',
            'translation' => 'Альбом успешно создан'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@successUpdate',
            'translation' => 'Альбом успешно обновлен'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@successDelete',
            'translation' => 'Альбом успешно удален'
        ],
        [
            'lang' => 'ru',
            'key' => 'album@notExist',
            'translation' => 'Альбом не существует'
        ],

        // RU - passwordReset
        [
            'lang' => 'ru',
            'key' => 'passwordReset@requestSuccessCreate',
            'translation' => 'На почту отправленно сообщение для сброса пароля'
        ],
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
