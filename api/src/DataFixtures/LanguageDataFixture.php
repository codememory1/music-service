<?php

namespace App\DataFixtures;

use App\DataFixtures\Templates\LanguageDataFixtureTemplate;
use App\Entity\Language;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class LanguageDataFixture.
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
final class LanguageDataFixture extends AbstractDataFixture
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new LanguageDataFixtureTemplate('en', 'English'),
            new LanguageDataFixtureTemplate('ru', 'Русский'),
            new LanguageDataFixtureTemplate('ua', 'Український'),
            new LanguageDataFixtureTemplate('es', 'Español'),
            new LanguageDataFixtureTemplate('fr', 'Français'),
            new LanguageDataFixtureTemplate('it', 'Italiano'),
            new LanguageDataFixtureTemplate('pl', 'Polski'),
            new LanguageDataFixtureTemplate('ar', 'عرب'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        /** @var Language $entity */
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("l-{$entity->getCode()}", $entity);
        }

        $manager->flush();
    }
}