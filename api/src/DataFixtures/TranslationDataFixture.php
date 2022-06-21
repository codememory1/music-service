<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\TranslationFactory;
use App\Entity\Translation;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class TranslationDataFixture.
 *
 * @package App\DataFixtures
 * @template-extends AbstractDataFixture<Translation>
 *
 * @author  Codememory
 */
class TranslationDataFixture extends AbstractDataFixture implements DependentFixtureInterface, FixtureGroupInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new TranslationFactory('ru', 'common@incorrectEmail', 'Некорректный E-mail'),
            new TranslationFactory('ru', 'common@passwordIsRequired', 'Пароль обязательный к заполнению'),
            new TranslationFactory('ru', 'common@incorrectPassword', 'Неверный пароль'),
            new TranslationFactory('ru', 'common@dataOutput', 'Вывод данных'),
            new TranslationFactory('ru', 'common@invalidRefreshToken', 'Не валидный Refresh-Token'),
            new TranslationFactory('ru', 'common@refreshTokenIsRequired', 'Не указан Refresh-Token'),
            new TranslationFactory('ru', 'common@failedToUpdateAccessToken', 'Не удалось обновить Access-Token'),
            new TranslationFactory('ru', 'common@incorrectPasswordBySchema', 'Пароль может состоять только из букв, цифр и спец., символов'),
            new TranslationFactory('ru', 'common@minPasswordLength', 'Пароль должен состоять не меньше чем из 8-ми символов'),
            new TranslationFactory('ru', 'common@invalidConfirmPassword', 'Некорректное подтверждение пароля'),
            new TranslationFactory('ru', 'common@invalidCode', 'Некорректный код'),
            new TranslationFactory('ru', 'common@titleTranslationKeyNotExist', 'Ключ перевода для имени не найден'),
            new TranslationFactory('ru', 'common@shortDescriptionTranslationKeyNotExist', 'Ключ перевода для описания не найден'),
            new TranslationFactory('ru', 'common@invalidOldPrice', 'Некорректный формат старой цены'),
            new TranslationFactory('ru', 'common@invalidPrice', 'Некорректный формат цены'),
            new TranslationFactory('ru', 'common@bannedDomainMail', 'Данный домен почты заблокирован'),
            new TranslationFactory('ru', 'common@uploadFileNotImage', 'Загружаемый файл не является изображением'),
            new TranslationFactory('ru', 'common@invalidStatus', 'Некорректный статус'),
            new TranslationFactory('ru', 'common@invalidSubtitles', 'Некорректный файл с субтитрами'),
            new TranslationFactory('ru', 'common@successAppealCanceled', 'Апелляция успешно отменена'),
            new TranslationFactory('ru', 'common@badAppealCanceled', 'Невозможно отменить апелляцию'),

            new TranslationFactory('ru', 'entityNotFound@page', 'Страница не найдена'),
            new TranslationFactory('ru', 'entityNotFound@language', 'Язык не найден'),
            new TranslationFactory('ru', 'entityNotFound@translationKey', 'Ключ перевода не найден'),
            new TranslationFactory('ru', 'entityNotFound@translation', 'Перевод не найден'),
            new TranslationFactory('ru', 'entityNotFound@permissionKey', 'Ключ разрешения не найден'),
            new TranslationFactory('ru', 'entityNotFound@role', 'Роль не найдена'),
            new TranslationFactory('ru', 'entityNotFound@subscription', 'Подписка не найдена'),
            new TranslationFactory('ru', 'entityNotFound@albumType', 'Тип альбома не найден'),
            new TranslationFactory('ru', 'entityNotFound@user', 'Пользователь не найден'),
            new TranslationFactory('ru', 'entityNotFound@album', 'Альбом не найден'),
            new TranslationFactory('ru', 'entityNotFound@userSession', 'Сеанс не найден'),
            new TranslationFactory('ru', 'entityNotFound@multimediaCategory', 'Категория мультимедии не найдена'),
            new TranslationFactory('ru', 'entityNotFound@performer', 'Исполнитель %performer% не найден'),
            new TranslationFactory('ru', 'entityNotFound@multimedia', 'Мультимедия не найдена'),

            new TranslationFactory('ru', 'entityExist@oneOfPermissionExistToRole', 'Одно из разрешений у данной роли уже существует'),
            new TranslationFactory('ru', 'entityExist@subscriptionPermissionKey', 'Данный ключ разрешения для подписок уже существует'),
            new TranslationFactory('ru', 'entityExist@subscription', 'Подписка с данным ключем уже существует'),
            new TranslationFactory('ru', 'entityExist@translationKey', 'Данный ключ перевода уже существует'),
            new TranslationFactory('ru', 'entityExist@albumType', 'Данный тип альбома уже существует'),

            new TranslationFactory('ru', 'auth@successAuthorization', 'Вы успешно вошли в аккаунт'),
            new TranslationFactory('ru', 'auth@authRequired', 'Вы не авторизованы'),
            new TranslationFactory('ru', 'auth@authNotRequired', 'Для выполнения данного действия вы должы выйти из аккаунта'),
            new TranslationFactory('ru', 'auth@authError', 'Произошла ошибка авторизации'),

            new TranslationFactory('ru', 'registration@successRegistration', 'Регистрация прошла успешно! На почту отправлена ссылка для активации аккаунта'),
            new TranslationFactory('ru', 'registration@registration', 'Регистрация'),
            new TranslationFactory('ru', 'registration@didNotProvideData', 'Сервис не может зарегестировать из-за отсутствия запрашиваемых данных'),

            new TranslationFactory('ru', 'userProfile@pseudonymIsRequired', 'Псевдоним обязательный к заполнению'),
            new TranslationFactory('ru', 'userProfile@maxPseudonymLength', 'Псевдоним не должен превышать 40 символов'),

            new TranslationFactory('ru', 'language@minCodeLength', 'Длина кода не должна быть меньше 2-х символов'),
            new TranslationFactory('ru', 'language@maxCodeLength', 'Длина кода не должна превышать 5 символов'),
            new TranslationFactory('ru', 'language@originalTitleIsRequired', 'Название языка обязательно к заполнению'),
            new TranslationFactory('ru', 'language@successCreate', 'Язык успешно создан'),
            new TranslationFactory('ru', 'language@successUpdate', 'Язык успешно обновлен'),
            new TranslationFactory('ru', 'language@successDelete', 'Язык успешно удален'),
            new TranslationFactory('ru', 'language@codeExist', 'Данный код языка уже существует'),

            new TranslationFactory('ru', 'user@existByEmail', 'Пользователь с данным E-mail уже существует'),

            new TranslationFactory('ru', 'userProfile@existByUser', 'Для данного пользователя профиль уже существует'),

            new TranslationFactory('ru', 'rolePermission@viewLanguagesWithFUllInfo', 'Просмотр полной информации о языках'),
            new TranslationFactory('ru', 'rolePermission@createLanguage', 'Создание языка'),
            new TranslationFactory('ru', 'rolePermission@updateLanguage', 'Редактирование языка'),
            new TranslationFactory('ru', 'rolePermission@deleteLanguage', 'Удаление языка'),
            new TranslationFactory('ru', 'rolePermission@showRoles', 'Просмотр информации о пользовательских ролях'),
            new TranslationFactory('ru', 'rolePermission@createUserRole', 'Создание пользовательской роли'),
            new TranslationFactory('ru', 'rolePermission@updateUserRole', 'Обновление пользовательской роли'),
            new TranslationFactory('ru', 'rolePermission@deleteUserRole', 'Удаление пользовательской роли'),
            new TranslationFactory('ru', 'rolePermission@updatePermissionsToRole', 'Обновление разрешений у роли'),
            new TranslationFactory('ru', 'rolePermission@showFullInfoSubscriptions', 'Просмотр полной информации о подписках'),
            new TranslationFactory('ru', 'rolePermission@createSubscription', 'Создание подписки'),
            new TranslationFactory('ru', 'rolePermission@updateSubscription', 'Обновление подписки'),
            new TranslationFactory('ru', 'rolePermission@deleteSubscription', 'Удаление подписки'),
            new TranslationFactory('ru', 'rolePermission@showFullInfoTranslations', 'Просмотр полной информации о переводах'),
            new TranslationFactory('ru', 'rolePermission@createTranslation', 'Создание перевода'),
            new TranslationFactory('ru', 'rolePermission@updateTranslation', 'Обновление перевода'),
            new TranslationFactory('ru', 'rolePermission@deleteTranslation', 'Удаление перевода'),
            new TranslationFactory('ru', 'rolePermission@showFullInfoAlbumTypes', 'Просмотр полной информации о типе альбома'),
            new TranslationFactory('ru', 'rolePermission@createAlbumType', 'Создание типа альбома'),
            new TranslationFactory('ru', 'rolePermission@updateAlbumType', 'Обновление типа альбома'),
            new TranslationFactory('ru', 'rolePermission@deleteAlbumType', 'Удаление типа альбома'),
            new TranslationFactory('ru', 'rolePermission@createAlbumToUser', 'Создание альбомов для пользователей'),
            new TranslationFactory('ru', 'rolePermission@updateAlbumToUser', 'Обновление альбомов у пользователей'),
            new TranslationFactory('ru', 'rolePermission@deleteAlbumToUser', 'Удаление альбомов у пользователей'),
            new TranslationFactory('ru', 'rolePermission@deleteUserSessionToUser', 'Удаление сеансов у пользователя'),
            new TranslationFactory('ru', 'rolePermission@showInfoAboutUserSession', 'Просмотр информации сеансов у пользователей'),
            new TranslationFactory('ru', 'rolePermission@showUserSessionTokensToUser', 'Просмотр токенов сессии у пользователей'),
            new TranslationFactory('ru', 'rolePermission@showUserSessions', 'Просмотр пользовательский сеансов'),
            new TranslationFactory('ru', 'rolePermission@createNotifications', 'Создание уведомлений'),
            new TranslationFactory('ru', 'rolePermission@showFullInfoMultimediaCategories', 'Просмотр полной информации о категориях мульмедии'),
            new TranslationFactory('ru', 'rolePermission@createMultimediaCategory', 'Создание категории мультмедии'),
            new TranslationFactory('ru', 'rolePermission@updateMultimediaCategory', 'Обновление категории мультмедии'),
            new TranslationFactory('ru', 'rolePermission@deleteMultimediaCategory', 'Удаление категории мультмедии'),
            new TranslationFactory('ru', 'rolePermission@multimediaStatusControlToUser', 'Управление статусами мультимедии пользователей'),
            new TranslationFactory('ru', 'rolePermission@showAllUserMultimedia', 'Просмотр мультимедии пользователей'),
            new TranslationFactory('ru', 'rolePermission@addMultimediaToUser', 'Добавление мультимедии к пользователю'),
            new TranslationFactory('ru', 'rolePermission@updateMultimediaToUser', 'Обновление мультимедий пользователя'),
            new TranslationFactory('ru', 'rolePermission@deleteMultimediaToUser', 'Просмотр мультимедий пользователей'),

            new TranslationFactory('ru', 'role@developer', 'Разработчик'),
            new TranslationFactory('ru', 'role@developerDescription', 'Данная роль преднозначеная только для тестирования в dev режиме'),
            new TranslationFactory('ru', 'role@keyIsRequired', 'Ключ роли обязательный к заполнению'),
            new TranslationFactory('ru', 'role@titleIsRequired', 'Название роли обязательно к заполнению'),
            new TranslationFactory('ru', 'role@exist', 'Роль с данным ключем уже существует'),
            new TranslationFactory('ru', 'role@successCreate', 'Роль успешно создана'),
            new TranslationFactory('ru', 'role@successUpdate', 'Роль успешно обновлена'),
            new TranslationFactory('ru', 'role@successDelete', 'Роль успешно удалена'),

            new TranslationFactory('ru', 'user@failedToIdentify', 'Не удалось идентифицировать пользователя'),

            new TranslationFactory('ru', 'token@successUpdate', 'Токен успешно обновлен'),

            new TranslationFactory('ru', 'logout@successLogout', 'Вы успешно вышли из аккаунта'),
            new TranslationFactory('ru', 'logout@failedToLogout', 'Не удалось выйти из аккаунта'),

            new TranslationFactory('ru', 'accessDenied@notEnoughPermissions', 'Недостаточно прав для выполнения данного действия'),
            new TranslationFactory('ru', 'accessDenied@notSubscription', 'Для выполнения данного действия, требуется подписка'),
            new TranslationFactory('ru', 'accessDenied@notSubscriptionPermissions', 'Недостаточно прав у подписки'),

            new TranslationFactory('ru', 'passwordReset@successSendRequestRestoration', 'На вашу почту отправлено сообщение для восстановление пароля'),
            new TranslationFactory('ru', 'passwordReset@requestRestoration', 'Запрос на восстановление пароля'),
            new TranslationFactory('ru', 'passwordReset@successRestorePassword', 'Пароль успешно восстановлен'),

            new TranslationFactory('ru', 'accountActivation@successActivate', 'Аккаунт успешно активирован'),

            new TranslationFactory('ru', 'rolePermission@successUpdatePermissionToRole', 'Разрешения роли успешно обновлены'),

            new TranslationFactory('ru', 'subscription@keyIsRequired', 'Ключ подписки обязательный к заполнению'),
            new TranslationFactory('ru', 'subscription@titleIsRequired', 'Имя подписки обязательно к заполнению'),
            new TranslationFactory('ru', 'subscription@descriptionIsRequired', 'Описание подписки обязательно к заполнению'),
            new TranslationFactory('ru', 'subscription@priceIsRequired', 'Цена подписки обязательна к заполнению'),
            new TranslationFactory('ru', 'subscription@statusIsRequired', 'Статус подписки обязательный к заполнению'),
            new TranslationFactory('ru', 'subscription@successCreate', 'Подписка успешно создана'),
            new TranslationFactory('ru', 'subscription@successUpdate', 'Подписка успешно обновлена'),
            new TranslationFactory('ru', 'subscription@successDelete', 'Подписка успешно удалена'),
            new TranslationFactory('ru', 'subscription@premium', 'Премиум'),
            new TranslationFactory('ru', 'subscription@premiumDescription', 'Премиум подписка дает вам доступ к использованию новых функций без ограничений'),
            new TranslationFactory('ru', 'subscription@artist', 'Артист'),
            new TranslationFactory('ru', 'subscription@artistDescription', 'Загружайте музыку и зарабатывайте с помощью монитизации'),
            new TranslationFactory('ru', 'subscription@family', 'Семейная'),
            new TranslationFactory('ru', 'subscription@familyDescription', 'Одна подписка на 7-ми аккаунтах'),

            new TranslationFactory('ru', 'subscriptionPermissionKey@createAlbum', 'Создание альбомов'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@updateAlbum', 'Обновление альбомов'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@deleteAlbum', 'Удаление альбомов'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@addMultimedia', 'Добавление мультимедий'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@listeningToMultimedia', 'Прослушивание мультимедии артистов'),

            new TranslationFactory('ru', 'translation@keyIsRequired', 'Ключ перевода обязательный к заполнению'),
            new TranslationFactory('ru', 'translation@translationIsRequired', 'Перевод обязательный к заполнению'),
            new TranslationFactory('ru', 'translation@languageIsRequired', 'Код языка обязательный к заполнению'),
            new TranslationFactory('ru', 'translation@successCreate', 'Перевод успешно создан'),
            new TranslationFactory('ru', 'translation@successUpdate', 'Перевод успешно обновлен'),
            new TranslationFactory('ru', 'translation@successDelete', 'Перевод успешно удален'),

            new TranslationFactory('ru', 'albumType@keyIsRequired', 'Ключ типа обязательный к заполнению'),
            new TranslationFactory('ru', 'albumType@titleIsRequired', 'Название типа обязательно к заполнению'),
            new TranslationFactory('ru', 'albumType@successCreate', 'Тип альбома успешно создан'),
            new TranslationFactory('ru', 'albumType@successUpdate', 'Тип альбома успешно обновлен'),
            new TranslationFactory('ru', 'albumType@successDelete', 'Тип альбома успешно удален'),
            new TranslationFactory('ru', 'albumType@remix', 'Альбом ремиксов'),
            new TranslationFactory('ru', 'albumType@double', 'Двойной альбом'),
            new TranslationFactory('ru', 'albumType@concert', 'Концертный альбом'),
            new TranslationFactory('ru', 'albumType@megnetic', 'Магнитоальбом'),
            new TranslationFactory('ru', 'albumType@minion', 'Мини-альбом'),
            new TranslationFactory('ru', 'albumType@compilation', 'Сборник'),
            new TranslationFactory('ru', 'albumType@bestCompilation', 'Сборник лучших хитов'),
            new TranslationFactory('ru', 'albumType@single', 'Синг'),

            new TranslationFactory('ru', 'album@titleIsRequired', 'Имя альбома обязательно к заполнению'),
            new TranslationFactory('ru', 'album@maxTitleLength', 'Название альбома не должно превышать 50 символов'),
            new TranslationFactory('ru', 'album@descriptionIsRequired', 'Описание альбома обязательно к заполнению'),
            new TranslationFactory('ru', 'album@maxDescriptionLength', 'Опиисание альбома не должно превышать 255 символов'),
            new TranslationFactory('ru', 'album@imageIsRequired', 'Изображение альбома обязательно к заполнению'),
            new TranslationFactory('ru', 'album@maxSizeImage', 'Изображение не должно превышать 5 МБ'),
            new TranslationFactory('ru', 'album@typeIsRequired', 'Тип альбома обязательный к заполнению'),
            new TranslationFactory('ru', 'album@successCreate', 'Альбом успешно создан'),
            new TranslationFactory('ru', 'album@successUpdate', 'Альбом успешно обновлен'),
            new TranslationFactory('ru', 'album@successDelete', 'Альбом успешно удален'),
            new TranslationFactory('ru', 'album@badAddMultimediaToSingleAlbum', 'Сингл альбом не может содержать более 1-й мультимедии'),

            new TranslationFactory('ru', 'userSession@successDelete', 'Сеанс успешно удален'),
            new TranslationFactory('ru', 'userSession@successDeleteMultiple', 'Сеансы успешно удалены'),

            new TranslationFactory('ru', 'notification@typeIsRequired', 'Тип уведомления обязателен к заполнению'),
            new TranslationFactory('ru', 'notification@toIsRequired', 'Получаетель уведомления обязателен к заполнению'),
            new TranslationFactory('ru', 'notification@titleIsRequired', 'Заголовок уведомления обязателен к заполнению'),
            new TranslationFactory('ru', 'notification@maxLengthTitle', 'Заголовок уведомления не должен превышать 50 символов'),
            new TranslationFactory('ru', 'notification@messageIsRequired', 'Сообщение уведомления обязательно к заполнению'),
            new TranslationFactory('ru', 'notification@maxLengthMessage', 'Сообщение уведомления не должно превышать 500 символов'),
            new TranslationFactory('ru', 'notification@invalidAction', 'Некорректное действие уведомления'),
            new TranslationFactory('ru', 'notification@successCreate', 'Уведомление успешно создано'),

            new TranslationFactory('ru', 'serviceAuth@authorizationCodeIsRequired', 'Код авторизации обязателен к заполнению'),

            new TranslationFactory('ru', 'multimediaCategory@titleIsRequired', 'Название категории обязательно к заполнению'),
            new TranslationFactory('ru', 'multimediaCategory@successCreate', 'Категория мультимедии успешно создана'),
            new TranslationFactory('ru', 'multimediaCategory@successUpdate', 'Категория мультимедии успешно обновлена'),
            new TranslationFactory('ru', 'multimediaCategory@successDelete', 'Категория мультимедии успешно удалена'),

            new TranslationFactory('ru', 'multimedia@typeIsRequired', 'Тип мультимедии обязательный к заполнению'),
            new TranslationFactory('ru', 'multimedia@albumIsRequired', 'Альбом обязательный к заполнению'),
            new TranslationFactory('ru', 'multimedia@titleIsRequired', 'Название мультимедии обязательно к заполнению'),
            new TranslationFactory('ru', 'multimedia@titleMaxLength', 'Название мультимедии не должно превышать 50 символов'),
            new TranslationFactory('ru', 'multimedia@descriptionMaxLength', 'Описание мультимедии не должно превышать 500 символов'),
            new TranslationFactory('ru', 'multimedia@categoryIsRequired', 'Категория мультимедии обязательна к заполнению'),
            new TranslationFactory('ru', 'multimedia@uploadFileIsNotSubtitles', 'Загружаемый файл не является субтитрами'),
            new TranslationFactory('ru', 'multimedia@isObsceneWordsIsRequired', 'Выбирите, содержится ли нецензурная лексика в мультимедии'),
            new TranslationFactory('ru', 'multimedia@previewIsRequired', 'Превью обязательно к заполнению'),
            new TranslationFactory('ru', 'multimedia@maxSizePreview', 'Превью не должно превышать 5МБ'),
            new TranslationFactory('ru', 'multimedia@uploadFileIsNotPreview', 'Загружаемый файл не является превью'),
            new TranslationFactory('ru', 'multimedia@successAdd', 'Мультимедия успешно добавлена и ожидает отправки на модерацию'),
            new TranslationFactory('ru', 'multimedia@invalidTrackMimeType', 'Платформа не поддерживает данный формат треков'),
            new TranslationFactory('ru', 'multimedia@invalidClipMimeType', 'Платформа не поддерживает данный формат клипов'),
            new TranslationFactory('ru', 'multimedia@multimediaIsRequired', 'Файл мультимедии обязательный к заполнению'),
            new TranslationFactory('ru', 'multimedia@badSendOnModeration', 'Невозможно отправить мультимедию на модерацию'),
            new TranslationFactory('ru', 'multimedia@successSendOnModeration', 'Мультимедия успешно отправлена на модерацию'),
            new TranslationFactory('ru', 'multimedia@successUpdate', 'Мультимедия успешно обновлена'),
            new TranslationFactory('ru', 'multimedia@successDelete', 'Мультимедия успешно удалена'),
            new TranslationFactory('ru', 'multimedia@badUpdateInStatus', 'Невозможно обновить мультимедию в статусе %status%'),
            new TranslationFactory('ru', 'multimedia@successSendOnAppeal', 'Мультимедия успешно отправлена на апелляцию'),
            new TranslationFactory('ru', 'multimedia@badSendOnAppeal', 'Невозможно отправить мультимедию на апелляцию в статусе %status%'),
            new TranslationFactory('ru', 'multimedia@badPublish', 'Невозможно опубликовать мультимедию'),
            new TranslationFactory('ru', 'multimedia@badUnpublish', 'Невозможно снять с публикации мультимедию'),
            new TranslationFactory('ru', 'multimedia@successPublish', 'Мультимедиа успешно опубликована'),
            new TranslationFactory('ru', 'multimedia@successUnpublish', 'Мультимедиа успешно снята с публикации'),
            new TranslationFactory('ru', 'multimedia@badAddMultimediaToUserInvalidSubscription', 'Невозможно добавить мультимедиа у пользователя не существует корректной подписки'),

            new TranslationFactory('ru', 'status@draft', 'Черновик'),
            new TranslationFactory('ru', 'status@moderation', 'Модерация'),
            new TranslationFactory('ru', 'status@published', 'Опубликован'),
            new TranslationFactory('ru', 'status@unpublished', 'Снят с публикации'),
            new TranslationFactory('ru', 'status@appeal', 'Апелляция'),
            new TranslationFactory('ru', 'status@appealCanceld', 'Отменена апелляция'),
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
            LanguageDataFixture::class,
            TranslationKeyDataFixture::class
        ];
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