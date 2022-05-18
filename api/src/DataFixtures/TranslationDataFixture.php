<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\TranslationFactory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class TranslationDataFixture.
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
class TranslationDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new TranslationFactory('ru', 'entityNotFound@page', 'Страница не найдена'),
            new TranslationFactory('ru', 'entityNotFound@language', 'Язык не найден'),
            new TranslationFactory('ru', 'entityNotFound@translationKey', 'Ключ перевода не найден'),
            new TranslationFactory('ru', 'entityNotFound@translation', 'Перевод не найден'),

            new TranslationFactory('ru', 'auth@successAuthorization', 'Вы успешно вошли в аккаунт'),

            new TranslationFactory('ru', 'registration@successRegistration', 'Регистрация прошла успешно! На почту отправлена ссылка для активации аккаунта'),

            new TranslationFactory('ru', 'language@minCodeLength', 'Длина кода не должна быть меньше 2-х символов'),
            new TranslationFactory('ru', 'language@maxCodeLength', 'Длина кода не должна превышать 5 символов'),
            new TranslationFactory('ru', 'language@originalTitleIsRequired', 'Название языка обязательно к заполнению'),
            new TranslationFactory('ru', 'language@successCreate', 'Язык успешно создан'),
            new TranslationFactory('ru', 'language@successUpdate', 'Язык успешно обновлен'),
            new TranslationFactory('ru', 'language@successDelete', 'Язык успешно удален'),
            new TranslationFactory('ru', 'language@codeExist', 'Данный код языка уже существует'),
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