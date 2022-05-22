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

            new TranslationFactory('ru', 'entityNotFound@page', 'Страница не найдена'),
            new TranslationFactory('ru', 'entityNotFound@language', 'Язык не найден'),
            new TranslationFactory('ru', 'entityNotFound@translationKey', 'Ключ перевода не найден'),
            new TranslationFactory('ru', 'entityNotFound@translation', 'Перевод не найден'),

            new TranslationFactory('ru', 'auth@successAuthorization', 'Вы успешно вошли в аккаунт'),

            new TranslationFactory('ru', 'registration@successRegistration', 'Регистрация прошла успешно! На почту отправлена ссылка для активации аккаунта'),
            new TranslationFactory('ru', 'registration@incorrectPassword', 'Пароль может состоять только из букв, цифр и спец., символов'),
            new TranslationFactory('ru', 'registration@minPasswordLength', 'Пароль должен состоять не меньше чем из 8-ми символов'),
            new TranslationFactory('ru', 'registration@invalidConfirmPassword', 'Некорректное подтверждение пароля'),
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

            new TranslationFactory('ru', 'rolePermission@createLanguage', 'Создание языка'),

            new TranslationFactory('ru', 'role@developer', 'Разработчик'),
            new TranslationFactory('ru', 'role@developerDescription', 'Данная роль преднозначеная только для тестирования в dev режиме'),
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