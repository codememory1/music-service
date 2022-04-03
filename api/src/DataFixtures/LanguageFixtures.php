<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class LanguageFixtures.
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
class LanguageFixtures extends Fixture
{
    /**
     * @var array
     */
    private array $languages = [
        [
            'code' => 'ru',
            'title' => 'Русский'
        ],
        [
            'code' => 'en',
            'title' => 'English'
        ]
    ];

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->languages as $language) {
            $languageEntity = new Language();

            $languageEntity
                ->setCode($language['code'])
                ->setTitle($language['title']);

            $this->addReference(sprintf('lang-%s', $language['code']), $languageEntity);

            $manager->persist($languageEntity);
        }

        $manager->flush();
    }
}
