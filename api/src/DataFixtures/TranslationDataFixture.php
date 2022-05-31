<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\TranslationFactory;
use App\Entity\Translation;
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
class TranslationDataFixture extends AbstractDataFixture implements DependentFixtureInterface
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

            new TranslationFactory('ru', 'entityNotFound@page', 'Страница не найдена'),
            new TranslationFactory('ru', 'entityNotFound@language', 'Язык не найден'),
            new TranslationFactory('ru', 'entityNotFound@translationKey', 'Ключ перевода не найден'),
            new TranslationFactory('ru', 'entityNotFound@translation', 'Перевод не найден'),
            new TranslationFactory('ru', 'entityNotFound@rolePermissionKey', 'Ключ разрешения не найден'),
            new TranslationFactory('ru', 'entityNotFound@role', 'Роль не найдена'),

            new TranslationFactory('ru', 'entityExist@oneOfPermissionExistToRole', 'Одно из разрешений у данной роли уже существует'),
            new TranslationFactory('ru', 'entityExist@subscriptionPermissionKey', 'Данный ключ разрешения для подписок уже существует'),

            new TranslationFactory('ru', 'auth@successAuthorization', 'Вы успешно вошли в аккаунт'),
            new TranslationFactory('ru', 'auth@authRequired', 'Вы не авторизованы'),
            new TranslationFactory('ru', 'auth@authNotRequired', 'Для выполнения данного действия вы должы выйти из аккаунта'),

            new TranslationFactory('ru', 'registration@successRegistration', 'Регистрация прошла успешно! На почту отправлена ссылка для активации аккаунта'),
            new TranslationFactory('ru', 'registration@registration', 'Регистрация'),

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

            new TranslationFactory('ru', 'passwordReset@successSendRequestRestoration', 'На вашу почту отправлено сообщение для восстановление пароля'),
            new TranslationFactory('ru', 'passwordReset@requestRestoration', 'Запрос на восстановление пароля'),
            new TranslationFactory('ru', 'passwordReset@successRestorePassword', 'Пароль успешно восстановлен'),

            new TranslationFactory('ru', 'accountActivation@successActivate', 'Аккаунт успешно активирован'),

            new TranslationFactory('ru', 'rolePermission@successUpdatePermissionToRole', 'Разрешения роли успешно обновлены'),
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
}