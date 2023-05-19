<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class LoadLanguageDataFixture extends Fixture
{
    private array $languages = [
        [
            'code' => 'RU',
            'name' => 'language.name.ru'
        ],
        [
            'code' => 'UA',
            'name' => 'language.name.ua'
        ],
        [
            'code' => 'EN',
            'name' => 'language.name.en'
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->languages as $languageData) {
            $language = new Language();

            $language->setCode($languageData['code']);
            $language->setName($languageData['name']);

            $manager->persist($language);
        }

        $manager->flush();
    }
}