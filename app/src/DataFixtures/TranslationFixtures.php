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
        // RU language
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
        [
            'lang'        => 'ru',
            'key'         => 'roleRightName@addTrack',
            'translation' => 'Добавление треков'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'roleRightName@updateTrack',
            'translation' => 'Обновление треков'
        ],
        [
            'lang'        => 'ru',
            'key'         => 'roleRightName@deleteTrack',
            'translation' => 'Удаление треков'
        ],

        // EN Language
        [
            'lang'        => 'en',
            'key'         => 'role@user',
            'translation' => 'User'
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
