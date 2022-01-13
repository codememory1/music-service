<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1637949862InsertTranslations
 *
 * @package Migrations
 */
final class Migration1637949862InsertTranslations extends AbstractMigration
{

    /**
     * @var array|array[]
     */
    private array $records = [
        [1, 'register@nameIsRequired', 'Имя обязательно к заполнению'],
        [1, 'register@nameLengthRange', 'Имя должно быть длиной от 3 до 32 символов'],
        [1, 'register@accountWithEmailExist', 'Пользователь с данным email, уже существует'],
        [1, 'register@successRegister', 'Регистрация прошла успешно! На почту отправлена ссылка для активации аккаунта'],
        [1, 'register@invalidPassword', 'Пароль должен состоять только из букв, цифр и спец., символов'],
        [1, 'security@samePassword', 'Пароли не совпадают'],
        [1, 'security@minPassword', 'Пароль должен состоять минимум из 8 символов'],
        [1, 'security@invalidTokenActivation', 'Не корректный токен активации'],
        [1, 'security@successAccountActivation', 'Аккаунт успешно активирован'],
        [1, 'security@passwordIsRequired', 'Пароль обязательный к заполнению'],
        [1, 'security@invalidRole', 'Не возможно выполнить данное действие, из-за некорректной роли'],
        [1, 'security@notAuth', 'Не авторизированны'],
        [1, 'security@wrongPassword', 'Не верный пароль'],
        [1, 'auth@loginIsRequired', 'Логин обязательный к заполнению'],
        [1, 'auth@badIdentification', 'Идентификация не прошла! Пользователь с данным логином не существует'],
        [1, 'auth@emailNotActivate', 'Данный аккаунт не активирован'],
        [1, 'auth@successAuth', 'Авторизация прошла успешно'],
        [1, 'playlist@nameLengthRange', 'Имя плейлиста должно быть от 5 до 100 символов'],
        [1, 'playlist@temporaryFormat', 'Для создания временного плейлиста, формат даты должен быть таким: dd.mm.yyyy hh:mm'],
        [1, 'playlist@exist', 'Плейлист с данным названием уже существует'],
        [1, 'playlist@successCreate', 'Плейлист успешно создан'],
        [1, 'playlist@successUpdate', 'Плейлист успешно обновлен'],
        [1, 'playlist@successDelete', 'Плейлист успешно удален'],
        [1, 'subscription@nameIsRequired', 'Имя подписки обязательно к заполнению'],
        [1, 'subscription@priceInTypeNumber', 'Цена должна быть числового типа'],
        [1, 'subscription@invalidStatusActivation', 'Некорректный статус активации'],
        [1, 'subscription@successCreate', 'Подписка успешно создана'],
        [1, 'subscription@successUpdate', 'Подписка успешно обновлена'],
        [1, 'subscription@successDelete', 'Подписка успешно удалена'],
        [1, 'passwordRecovery@withoutAuth', 'Для восстановления пароля! Вы не должны быть авторизированны'],
        [1, 'passwordRecovery@successRestoreRequest', 'На почту отправлено сообщение с кодом для изменения пароля'],
        [1, 'passwordRecovery@invalidCode', 'Некорректный код изменения пароля'],
        [1, 'passwordRecovery@successRecovery', 'Пароль успешно изменен'],
        [1, 'translation@langIsRequired', 'Код языка обязательный к заполнению'],
        [1, 'translation@translationKeyIsRequired', 'Ключ перевода обязательный к заполнению'],
        [1, 'translation@translationKeyMaxLength', 'Ключ перевода должен состоять максимум из 64 символа'],
        [1, 'translation@translationIsRequired', 'Перевод обязательный к заполнению'],
        [1, 'translation@successCreateLang', 'Язык успешно создан'],
        [1, 'translation@langExist', 'Данный языка уже существует'],
        [1, 'translation@langNotExist', 'Данного языка не существует'],
        [1, 'translation@translationExist', 'Данный перевод для текущего языка уже существует'],
        [1, 'translation@successAddTranslation', 'Перевод успешно добавлен'],
        [1, 'translation@successUpdateCache', 'Кэш переводов успешно обновлен'],
        [1, 'common@invalidEmail', 'Некорректный email'],
        [1, 'common@userNotExist', 'Пользователь не существует'],
        [1, 'common@userExist', 'Пользователь уже существует'],
        [1, 'subscription@activeInTypeBoolean', 'Поле "активный" должно иметь значение 0 или 1'],
        [1, 'playlist@notExist', 'Плейлист не существует'],
        [1, 'subscription@notExist', 'Подписка не найдена'],
        [1, 'confirmRegistration', 'Подтверждение регистрации'],
        [1, 'passwordRecovery', 'Восстановление пароля'],
        [1, 'track@nameIsRequired', 'Имя трека обязательно к заполнению'],
        [1, 'track@nameMaxLength', 'Имя трека должно состоять максимум из 255 символов'],
        [1, 'track@categoryIsRequired', 'Категория трека обязательно к заполнению'],
        [1, 'track@imageIsRequired', 'Изображение трека обязательно к заполнению'],
        [1, 'track@albumIsRequired', 'Альбом трека обязательный к заполнению'],
        [1, 'track@durationTimeIsRequired', 'Время продолжительности трека обязательно к заполнению'],
        [1, 'track@durationTimeInTypeInteger', 'Время продолжительности трека должно быть целым числом'],
        [1, 'track@foulLanguageIsRequired', 'Статус нецензурной лексики обязателен к заполнению'],
        [1, 'album@notExist', 'Выбранный альбом не существует'],
        [1, 'album@exist', 'Данный альбом уже существует'],
        [1, 'album@nameIsRequired', 'Имя альбома обязательно к заполнению'],
        [1, 'album@nameLengthRange', 'Длина имени альбома, должна состовлять 5-255 символов'],
        [1, 'album@typeNotExist', 'Выбранный тип альбома не существует'],
        [1, 'album@successCreate', 'Альбом успешно создан'],
        [1, 'album@typeIsRequired', 'Укажите тип альбома'],
        [1, 'trackCategory@exist', 'Данная категория уже существует'],
        [1, 'trackCategory@notExist', 'Выбранная категория трека не существует'],
        [1, 'track@successAdd', 'Трек успешно добавлен'],
        [1, 'common@invalidImageType', 'Некорректный тип загружаемого изображение - файл не является картинкой'],
        [1, 'track@numberOfImages', 'Для трека должно быть загружено одно изображение'],
        [1, 'track@notExist', 'Трек не найден'],
        [1, 'track@successDelete', 'Трек успешно удален'],
        [1, 'track@textIsRequired', 'Текст трека обязательный к заполнению'],
        [1, 'track@successAddText', 'Трек песни успешно добавлен'],
        [1, 'common@invalidRefreshToken', 'Некорректный Refresh-Token'],
        [1, 'refreshToken@successRefreshAccessToken', 'Access-Token успешно обновлен'],
        [1, 'track@invalidSubtitlesType', 'Некорректный вид субтитров'],
        [1, 'track@invalidFormatSubtitles', 'Некорректный формат субтитров'],
        [1, 'track@dublicateLabels', 'В субтитрах существуют повторные метки'],
        [1, 'track@successAddSubtitles', 'Субтитры успешно добавлены'],
        [1, 'track@numberSubtitleFiles', 'Количество файлов с субтитрами должно составлять 1'],
        [1, 'track@subtitleMimeType', 'Некорретный mime-type файла'],
        [1, 'track@subtitleExtension', 'Расширение файла с субтитрами должно быть .srt'],
        [1, 'track@subtitleManualIsRequired', 'Ручной ввод субтитров обязательный к заполнению'],
        [1, 'track@subtitleInvalidFormat', 'Некорректный формат субтитров'],

        // Account subdomain
        [1, 'generalSettings', 'Основные настройки'],
        [1, 'security', 'Безопасность'],
        [1, 'login', 'Логин'],
        [1, 'language', 'Язык'],
        [1, 'region', 'Регион'],
        [1, 'notifications', 'Уведомления'],
        [1, 'connectedApps', 'Подключенные приложения'],
        [1, 'activeSessions', 'Активные сеансы'],
        [1, 'deleteSession', 'Удалить сеанс'],
        [1, 'deleteAllActiveSessions', 'Удалить все активные сеансы'],
        [1, 'activeNow', 'В данный момент активен'],
        [1, 'oldPassword', 'Старый пароль'],
        [1, 'newPassword', 'Новый пароль'],
        [1, 'repeatPassword', 'Подвреждение пароля'],
        [1, 'btn@updateSecuritySettings', 'Обновить настройки безопаности'],
        [1, 'btn@update', 'Обновить'],
        [1, 'btn@cancel', 'Отменить'],
        [1, 'changePassword', 'Изменение пароля'],
        [1, 'recommendedActiveSession', 'Рекомендация! Если увидели подозрительный сеанс, удалите его и смените пароль.'],
    ];

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('language_translations');

        $schema->insertRecords(['lang_id', 'key', 'translation'], ...$this->records);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql(sprintf('DELETE FROM `language_translations` WHERE `id` <= %s', count($this->records)));

    }

}