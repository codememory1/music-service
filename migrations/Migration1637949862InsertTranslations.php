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
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('language_translations');

        $schema->insertRecords(['lang_id', 'translation_key_id', 'translation'], ...[
            [1, 1, 'Имя обязательно к заполнению'],
            [1, 2, 'Имя должно быть длиной от 3 до 32 символов'],
            [1, 3, 'Пользователь с данным email, уже существует'],
            [1, 4, 'Регистрация прошла успешно! На почту отправлена ссылка для активации аккаунта'],
            [1, 5, 'Пароль должен состоять только из букв, цифр и спец., символов'],
            [1, 6, 'Пароли не совпадают'],
            [1, 7, 'Пароль должен состоять минимум из 8 символов'],
            [1, 8, 'Не корректный токен активации'],
            [1, 9, 'Аккаунт успешно активирован'],
            [1, 10, 'Пароль обязательный к заполнению'],
            [1, 11, 'Не возможно выполнить данное действие, из-за некорректной роли'],
            [1, 12, 'Не авторизированны'],
            [1, 13, 'Не верный пароль'],
            [1, 14, 'Логин обязательный к заполнению'],
            [1, 15, 'Идентификация не прошла! Пользователь с данным логином не существует'],
            [1, 16, 'Данный аккаунт не активирован'],
            [1, 17, 'Авторизация прошла успешно'],
            [1, 18, 'Имя плейлиста должно быть от 5 до 100 символов'],
            [1, 19, 'Для создания временного плейлиста, формат даты должен быть таким: dd.mm.yyyy hh:mm'],
            [1, 20, 'Плейлист с данным названием уже существует'],
            [1, 21, 'Плейлист успешно создан'],
            [1, 22, 'Плейлист успешно обновлен'],
            [1, 23, 'Плейлист успешно удален'],
            [1, 24, 'Имя подписки обязательно к заполнению'],
            [1, 25, 'Цена должна быть числового типа'],
            [1, 26, 'Некорректный статус активации'],
            [1, 27, 'Подписка успешно создана'],
            [1, 28, 'Подписка успешно обновлена'],
            [1, 29, 'Подписка успешно удалена'],
            [1, 30, 'Для восстановления пароля! Вы не должны быть авторизированны'],
            [1, 31, 'На почту отправлено сообщение с кодом для изменения пароля'],
            [1, 32, 'Некорректный код изменения пароля'],
            [1, 33, 'Пароль успешно изменен'],
            [1, 34, 'Код языка обязательный к заполнению'],
            [1, 35, 'Ключ перевода обязательный к заполнению'],
            [1, 36, 'Ключ перевода должен состоять максимум из 64 символа'],
            [1, 37, 'Перевод обязательный к заполнению'],
            [1, 38, 'Язык успешно создан'],
            [1, 39, 'Данный языка уже существует'],
            [1, 40, 'Данного языка не существует'],
            [1, 41, 'Данный перевод для текущего языка уже существует'],
            [1, 42, 'Перевод успешно добавлен'],
            [1, 43, 'Кэш переводов успешно обновлен'],
            [1, 44, 'Некорректный email'],
            [1, 45, 'Пользователь не существует'],
            [1, 46, 'Пользователь уже существует'],
            [1, 47, 'Поле "активный" должно иметь значение 0 или 1'],
            [1, 48, 'Плейлист не существует'],
            [1, 49, 'Подписка не найдена'],
            [1, 50, 'Подтверждение регистрации'],
            [1, 51, 'Восстановление пароля'],
            [1, 52, 'Имя трека обязательно к заполнению'],
            [1, 53, 'Имя трека должно состоять максимум из 255 символов'],
            [1, 54, 'Категория трека обязательно к заполнению'],
            [1, 55, 'Изображение трека обязательно к заполнению'],
            [1, 56, 'Альбом трека обязательный к заполнению'],
            [1, 57, 'Время продолжительности трека обязательно к заполнению'],
            [1, 58, 'Время продолжительности трека должно быть целым числом'],
            [1, 59, 'Статус нецензурной лексики обязателно к заполнению'],
            [1, 60, 'Выбранный альбом не существует'],
            [1, 61, 'Данный альбом уже существует'],
            [1, 62, 'Данная категория уже существует'],
            [1, 63, 'Выбранная категория трека не существует'],
        ]);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DELETE FROM `language_translations` WHERE `translation_key_id` <= 63');

    }

}