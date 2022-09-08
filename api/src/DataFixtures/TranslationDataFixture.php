<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\TranslationFactory;
use App\Entity\Translation;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataFixture<Translation>
 */
final class TranslationDataFixture extends AbstractDataFixture implements DependentFixtureInterface, FixtureGroupInterface
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
            new TranslationFactory('ru', 'common@authFromUnknownDevice', 'Авторизация с незнакомого устройства'),
            new TranslationFactory('ru', 'common@authFromUnknownDeviceMessage', 'На ваш аккаунт был выполнен вход с незнакомого устройтсва. Название устройства: "%device%", IP-адрес: "%ip%"'),
            new TranslationFactory('ru', 'common@invalidMultimediaFile', 'Произошла ошибка при попытке прочитать файл'),
            new TranslationFactory('ru', 'common@codeIsRequired', 'Код обязательный к заполнению'),
            new TranslationFactory('ru', 'common@onlyOneImage', 'Невозможно загрузить более одного изображения'),

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
            new TranslationFactory('ru', 'entityNotFound@mediaLibrary', 'Медиатека не найдена'),
            new TranslationFactory('ru', 'entityNotFound@playlist', 'Плейлист не найден'),
            new TranslationFactory('ru', 'entityNotFound@playlistDirectory', 'Директория плейлиста не найдена'),
            new TranslationFactory('ru', 'entityNotFound@userProfile', 'Профиль пользователя не найден'),
            new TranslationFactory('ru', 'entityNotFound@friend', 'Друг не найден'),
            new TranslationFactory('ru', 'entityNotFound@multimediaEvent', 'События мультимедиа не найдено'),
            new TranslationFactory('ru', 'entityNotFound@mediaLibraryEvent', 'События медиатеки не найдено'),
            new TranslationFactory('ru', 'entityNotFound@runningMultimedia', 'Запущенная мультимедиа не найдена'),
            new TranslationFactory('ru', 'entityNotFound@streamRunningMultimedia', 'Стриминг запущенной мультимедиа не найден'),
            new TranslationFactory('ru', 'entityNotFound@listenToHistory', 'Прослушивание в истории не найдено'),

            new TranslationFactory('ru', 'entityExist@oneOfPermissionExistToRole', 'Одно из разрешений у данной роли уже существует'),
            new TranslationFactory('ru', 'entityExist@subscriptionPermissionKey', 'Данный ключ разрешения для подписок уже существует'),
            new TranslationFactory('ru', 'entityExist@subscription', 'Подписка с данным ключем уже существует'),
            new TranslationFactory('ru', 'entityExist@translationKey', 'Данный ключ перевода уже существует'),
            new TranslationFactory('ru', 'entityExist@albumType', 'Данный тип альбома уже существует'),
            new TranslationFactory('ru', 'entityExist@mediaLibrary', 'У данного пользователя уже создана медиатека'),
            new TranslationFactory('ru', 'entityExist@multimediaToPlaylist', 'Данная мультимедиа уже существует в текущем плейлисте'),
            new TranslationFactory('ru', 'entityExist@friend', 'Данный пользователь уже был добавлен в список ваших друзей'),
            new TranslationFactory('ru', 'entityExist@multimediaInMediaLibraryToUser', 'У данного пользователя уже существует данная мультимедиа'),
            new TranslationFactory('ru', 'entityExist@multimediaMediaLibraryEvent', 'Данное событие уже добавлено на данное мультимедиа'),
            new TranslationFactory('ru', 'entityExist@mediaLibraryEvent', 'Данное событие уже добавлено в медиатеку'),

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
            new TranslationFactory('ru', 'rolePermission@albumStatusControlToUser', 'Управление статусами альбомов пользователей'),
            new TranslationFactory('ru', 'rolePermission@createMediaLibraryToUser', 'Создание медиатеки пользователя'),
            new TranslationFactory('ru', 'rolePermission@updateMediaLibraryToUser', 'Обновление медиатеки пользователя'),
            new TranslationFactory('ru', 'rolePermission@showMediaLibraryToUser', 'Просмотр мультимедии пользователя'),
            new TranslationFactory('ru', 'rolePermission@deleteMultimediaMediaLibraryToUser', 'Удаление мультимедии из медиатеки пользователя'),
            new TranslationFactory('ru', 'rolePermission@deleteMultimediaFromMediaLibraryToUser', 'Удаление мультимедии из медиатеки пользователя'),
            new TranslationFactory('ru', 'rolePermission@showUserPlaylists', 'Просмотр плейлистов пользователя'),
            new TranslationFactory('ru', 'rolePermission@showFullInfoUserPlaylists', 'Просмотр информации о плейлисте'),
            new TranslationFactory('ru', 'rolePermission@createPlaylistToUser', 'Создание плейлистов для пользователя'),
            new TranslationFactory('ru', 'rolePermission@updatePlaylistToUser', 'Обновление плейлистов у пользователя'),
            new TranslationFactory('ru', 'rolePermission@deletePlaylistToUser', 'Удаление плейлистов у пользователя'),
            new TranslationFactory('ru', 'rolePermission@showPlaylistDirectoriesToUser', 'Просмотр директорий плейлиста у пользователя'),
            new TranslationFactory('ru', 'rolePermission@showFullInfoPlaylistDirectoriesToUser', 'Просмотр полной информации о директории плейлиста'),
            new TranslationFactory('ru', 'rolePermission@createPlaylistDirectoryToUser', 'Создание директории плейлиста у пользователя'),
            new TranslationFactory('ru', 'rolePermission@updatePlaylistDirectoryToUser', 'Обновление директории плейлиста у пользователя'),
            new TranslationFactory('ru', 'rolePermission@deletePlaylistDirectoryToUser', 'Удаление директории плейлиста у пользователя'),
            new TranslationFactory('ru', 'rolePermission@addMultimediaToPlaylistDirectory', 'Добавление мультимедиа в директорию плейлиста пользователя'),
            new TranslationFactory('ru', 'rolePermission@deleteMultimediaToPlaylistDirectory', 'Удаление мультимедиа из директории плейлиста пользователя'),
            new TranslationFactory('ru', 'rolePermission@updateUserProfileDesign', 'Редактирование дизайна профиля у пользователя'),
            new TranslationFactory('ru', 'rolePermission@addFriendToUser', 'Добавление друзей пользователю'),
            new TranslationFactory('ru', 'rolePermission@deleteFriendToUser', 'Удаление друзей у пользователя'),

            new TranslationFactory('ru', 'role@developer', 'Разработчик'),
            new TranslationFactory('ru', 'role@developerDescription', 'Данная роль преднозначена только для тестирования в dev режиме'),
            new TranslationFactory('ru', 'role@keyIsRequired', 'Ключ роли обязательный к заполнению'),
            new TranslationFactory('ru', 'role@titleIsRequired', 'Название роли обязательно к заполнению'),
            new TranslationFactory('ru', 'role@exist', 'Роль с данным ключем уже существует'),
            new TranslationFactory('ru', 'role@successCreate', 'Роль успешно создана'),
            new TranslationFactory('ru', 'role@successUpdate', 'Роль успешно обновлена'),
            new TranslationFactory('ru', 'role@successDelete', 'Роль успешно удалена'),
            new TranslationFactory('ru', 'role@systemUser', 'Системный пользователь'),
            new TranslationFactory('ru', 'role@systemUserDescription', 'Данная роль преднозначена только для системных пользователей, под которыми невозможно войти'),

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
            new TranslationFactory('ru', 'passwordReset@blocked', 'Слишком много запросов на восстановление пароля! Повторите попытку позже'),

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

            new TranslationFactory('ru', 'subscriptionPermissionKey@showMyAlbums', 'Просмотр моих альбомов'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@createAlbum', 'Создание альбомов'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@updateAlbum', 'Обновление альбомов'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@deleteAlbum', 'Удаление альбомов'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@showMyMultimedia', 'Просмотр моей мультимедиа'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@addMultimedia', 'Добавление мультимедий'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@updateMultimedia', 'Обновление мультимедиа'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@deleteMultimedia', 'Удаление мультимедиа'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@listeningToMultimedia', 'Прослушивание мультимедии артистов'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@controlSubscriptionOnArtist', 'Подписаться или отписаться от артиста'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@acceptingSubscribers', 'Возможность подписываться на артиста'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@addMultimediaToMediaLibrary', 'Добавление мультимедиа в медиатеку'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@updateMultimediaFromMediaLibrary', 'Обновление мультимедиа из медиатеки'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@deleteMultimediaFromMediaLibrary', 'Удаление мультимедиа из медиатеки'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@showMyPlaylists', 'Просмотр моих плейлистов'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@createPlaylist', 'Создание плейлиста'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@updatePlaylist', 'Обновление плейлиста'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@deletePlaylist', 'Удаление плейлиста'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@showMyPlaylistDirectories', 'Просмотр моих директорий плелиста'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@createDirectoryToPlaylist', 'Создание директорий в плейлисте'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@updateDirectoryToPlaylist', 'Обновление директории плейлиста'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@deleteDirectoryToPlaylist', 'Удаление директорий плейлиста'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@updateProfileDesign', 'Редактирование дизайна профиля'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@addAsFriend', 'Добавление пользователей в друзья'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@showMyFriends', 'Просмотр моих друзей'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@deleteFriend', 'Удаление пользователя из списка друзей'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@shareMultimediaWithFriends', 'Поделится мультимедией с друзьями'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@shareMediaLibraryWithFriends', 'Поделится медиатекой с друзьями'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@controlMultimediaMediaLibraryEvent', 'Контроль над событиями мультимедиа в медиатеки'),
            new TranslationFactory('ru', 'subscriptionPermissionKey@controlMediaLibraryEvent', 'Контроль над событиями медиатеки'),

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
            new TranslationFactory('ru', 'albumType@single', 'Сингл'),

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
            new TranslationFactory('ru', 'album@badPublicationToAlreadyPublication', 'Данный альбом уже опубликован'),
            new TranslationFactory('ru', 'album@successPublication', 'Альбом успешно опубликован'),
            new TranslationFactory('ru', 'album@badPublicationWithoutPublishedMultimedia', 'Невозможно публиковать альбом! Альбом должен содержать хотя бы одну опубликованную мультимедиа'),

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

            new TranslationFactory('ru', 'userNotification@titleNewRelease', 'Новый релиз'),
            new TranslationFactory('ru', 'userNotification@messageNewReleaseToArtist', 'У артиста %artist_pseudonym% вышел новый релиз'),
            new TranslationFactory('ru', 'userNotification@titleSharedMultimedia', 'С вами поделились мультимедией'),
            new TranslationFactory('ru', 'userNotification@messageSharedMultimedia', 'Ваш друг «%friend_name%» поделился с вами мультимедией «%multimedia_original_title%»'),

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
            new TranslationFactory('ru', 'multimedia@successSetLike', 'Лайк успешно установлен'),
            new TranslationFactory('ru', 'multimedia@successSetDislike', 'Дизлайк успешно установлен'),
            new TranslationFactory('ru', 'multimedia@successDeleteLike', 'Лайк успешно снят'),
            new TranslationFactory('ru', 'multimedia@successDeleteDislike', 'Дизлайк успешно снят'),
            new TranslationFactory('ru', 'multimedia@badDuration', 'Продолжительность мультимедиа не должно превышать %allowed_duration% секунд'),
            new TranslationFactory('ru', 'multimedia@successPlay', 'Мультимедиа успешно воспроизведено'),
            new TranslationFactory('ru', 'multimedia@successPause', 'Воспроизведение мультимедиа успешно остановлено'),

            new TranslationFactory('ru', 'multimediaPlaylist@successMoveToDirectory', 'Мультимедиа успешно перемещена в директорию'),

            new TranslationFactory('ru', 'status@draft', 'Черновик'),
            new TranslationFactory('ru', 'status@moderation', 'Модерация'),
            new TranslationFactory('ru', 'status@published', 'Опубликован'),
            new TranslationFactory('ru', 'status@unpublished', 'Снят с публикации'),
            new TranslationFactory('ru', 'status@appeal', 'Апелляция'),
            new TranslationFactory('ru', 'status@appealCanceld', 'Отменена апелляция'),

            new TranslationFactory('ru', 'artist@successSubscribe', 'Вы успешно подписались на артиста'),
            new TranslationFactory('ru', 'artist@failedSubscribeOnArtist', 'Вы уже подписаны на данного артиста'),
            new TranslationFactory('ru', 'artist@successUnsubscribe', 'Вы успешно отписались от данного артиста'),
            new TranslationFactory('ru', 'artist@failedUnsubscribeOnArtist', 'Вы не подписаны на данного артиста'),

            new TranslationFactory('ru', 'mediaLibrary@successCreate', 'Медиатека успешно создана'),
            new TranslationFactory('ru', 'mediaLibrary@successUpdate', 'Медиатека успешно обновлена'),
            new TranslationFactory('ru', 'mediaLibrary@invalidStatus', 'Некорректный статус медиатеки'),
            new TranslationFactory('ru', 'mediaLibrary@notCreated', 'Медиатека не создана'),
            new TranslationFactory('ru', 'mediaLibrary@successShare', 'Вы успешно поделились медиатекой'),

            new TranslationFactory('ru', 'multimediaMediaLibrary@multimediaAlreadyAdd', 'Данная мультимедиа уже добавлена в медиатеку'),
            new TranslationFactory('ru', 'multimediaMediaLibrary@successAdd', 'Мультимедиа успешно добавлена в медиатеку'),
            new TranslationFactory('ru', 'multimediaMediaLibrary@successDelete', 'Мультимедиа успешно удалена'),
            new TranslationFactory('ru', 'multimediaMediaLibrary@successShare', 'Вы успешно поделились мультимедией'),

            new TranslationFactory('ru', 'multimediaCategoryTitle@spatialAudio', 'Пространственное аудио'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@calmness', 'Спокойствие'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@sunrise', 'Восход'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@sport', 'Спорт'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@concentration', 'Концентрация'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@pop', 'Поп'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@alternative', 'Альтернатива'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@rock', 'Рок'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@goodHealth', 'Хорошее самочувствие'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@jazz', 'Джаз'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@forKids', 'Для детей'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@DJMixes', 'DJ-миксы'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@90s', '90-e'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@2000s', '2000-е'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@2010s', '2010-е'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@main', 'Главное'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@motivation', 'Мотивация'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@hits', 'Хиты'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@charts', 'Чарты'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@india', 'Индии'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@k-pap', 'K-pap'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@musicForGamers', 'Музыка для геймеров'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@metal', 'Метал'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@rockClassic', 'Классика рока'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@hardRock', 'Хард-рок'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@liveMusic', 'Живая музыка'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@melancholy', 'Меланхолия'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@dream', 'Сон'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@romance', 'Романтика'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@onTheRoad', 'В дорогу'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@soulAndFunk', 'Соул и фанк'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@blues', 'Блюз'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@country', 'Кантри'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@fromAroundTheWorld', 'Со всего мира'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@retro', 'Ретро'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@african', 'Африканская'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@reggae', 'Регги'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@latinAmerican', 'Латиноамериканская'),
            new TranslationFactory('ru', 'multimediaCategoryTitle@arabic', 'Арабская'),

            new TranslationFactory('ru', 'playlist@titleIsRequired', 'Название плейлиста обязательно к заполнению'),
            new TranslationFactory('ru', 'playlist@titleMaxLength', 'Название плейлиста не должно превышать 50 символов'),
            new TranslationFactory('ru', 'playlist@maxSizeImage', 'Изображение плейлиста не должно превышать 5МБ'),
            new TranslationFactory('ru', 'playlist@successCreate', 'Плейлист успешно создан'),
            new TranslationFactory('ru', 'playlist@successUpdate', 'Плейлист успешно обновлен'),
            new TranslationFactory('ru', 'playlist@successDelete', 'Плейлист успешно удален'),
            new TranslationFactory('ru', 'playlist@successAddMultimedia', 'Мультимедиа успешно добавлена в плейлист'),
            new TranslationFactory('ru', 'playlist@successDeleteMultimedia', 'Мультимедиа успешно удалена из плейлиста'),

            new TranslationFactory('ru', 'playlistDirectory@titleIsRequired', 'Название директории обязательно к заполнению'),
            new TranslationFactory('ru', 'playlistDirectory@titleMaxLength', 'Название директории не должно превышать 50 символов'),
            new TranslationFactory('ru', 'playlistDirectory@successCreate', 'Директория успешно создана'),
            new TranslationFactory('ru', 'playlistDirectory@successUpdate', 'Директория успешно обновлена'),
            new TranslationFactory('ru', 'playlistDirectory@successDelete', 'Директория успешно удалена'),
            new TranslationFactory('ru', 'playlistDirectory@successAddMultimedia', 'Мультимедиа успешно добавлена'),

            new TranslationFactory('ru', 'userProfileDesign@coverImageIsRequired', 'Обложка обязательна к заполнению'),
            new TranslationFactory('ru', 'userProfileDesign@maxSizeCoverImage', 'Размер обложки не должен превышать 10МБ'),
            new TranslationFactory('ru', 'userProfileDesign@uploadFileIsNotCoverImage', 'Загруженный файл не является обложкой'),
            new TranslationFactory('ru', 'userProfileDesign@invalidDesignComponents', 'Некорректные дизайн компоненты'),
            new TranslationFactory('ru', 'userProfileDesign@successUpdate', 'Дизайн профиля успешно обновлен'),

            new TranslationFactory('ru', 'friend@successAdd', 'Пользователь успешно добавлен в список ваших друзей'),
            new TranslationFactory('ru', 'friend@successDelete', 'Пользователь успешно удален из списка друзей'),
            new TranslationFactory('ru', 'friend@notAccept', 'Невозможно добавить в друзья данного пользователя'),
            new TranslationFactory('ru', 'friend@addMyselfAsFriend', 'Невозможно добавить в друзья самого себя'),
            new TranslationFactory('ru', 'friend@successAccept', 'Вы успешно приняли заявку на дружбу'),

            new TranslationFactory('ru', 'event@successAdd', 'Событие успешно добавлено'),
            new TranslationFactory('ru', 'event@successUpdate', 'Событие успешно обновлено'),
            new TranslationFactory('ru', 'event@successDelete', 'Событие успешно удалено'),
            new TranslationFactory('ru', 'event@keyIsRequired', 'Ключ события обязательный к заполнению'),
            new TranslationFactory('ru', 'event@invalidPayload', 'Некорректные входные данные события'),
            new TranslationFactory('ru', 'event@invalidRangeFromTime', 'Время старта не может превышать время окончания'),

            new TranslationFactory('ru', 'streamMultimedia@multimediaIsRequired', 'Мультимедиа обязательна к заполнению'),
            new TranslationFactory('ru', 'streamMultimedia@toUserSessionIsRequired', 'Сессия обазательна к заполнению'),

            new TranslationFactory('ru', 'multimediaListeningHistory@successDelete', 'Прослушивание успешно удалено из истории'),
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