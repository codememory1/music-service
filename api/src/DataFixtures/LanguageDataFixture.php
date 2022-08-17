<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\LanguageFactory;
use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataFixture<Language>
 */
final class LanguageDataFixture extends AbstractDataFixture implements FixtureGroupInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new LanguageFactory('en', 'English'),
            new LanguageFactory('ru', 'Русский'),
            new LanguageFactory('ua', 'Український'),
            new LanguageFactory('es', 'Español'),
            new LanguageFactory('fr', 'Français'),
            new LanguageFactory('it', 'Italiano'),
            new LanguageFactory('pl', 'Polski'),
            new LanguageFactory('ar', 'عرب'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("l-{$entity->getCode()}", $entity);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public static function getGroups(): array
    {
        return [
            'translation'
        ];
    }
}