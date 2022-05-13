<?php

namespace App\DataFixtures;

use App\DataFixtures\Templates\TranslationDataFixtureTemplate;
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
            new TranslationDataFixtureTemplate('ru', 'entityNotFound@page', 'Страница не найдена'),
            new TranslationDataFixtureTemplate('ru', 'entityNotFound@language', 'Язык не найден'),
            new TranslationDataFixtureTemplate('ru', 'entityNotFound@translationKey', 'Ключ перевода не найден'),
            new TranslationDataFixtureTemplate('ru', 'entityNotFound@translation', 'Перевод не найден'),

            new TranslationDataFixtureTemplate('ru', 'auth@successAuthorization', 'Вы успешно вошли в аккаунт'),

            new TranslationDataFixtureTemplate('ru', 'registration@successRegistration', 'Регистрация прошла успешно! На почту отправлена ссылка для активации аккаунта'),
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