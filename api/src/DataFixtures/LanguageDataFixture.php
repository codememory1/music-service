<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\LanguageFactory;
use App\Entity\Language;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class LanguageDataFixture.
 *
 * @package App\DataFixtures
 * @template-extends AbstractDataFixture<Language>
 *
 * @author  Codememory
 */
final class LanguageDataFixture extends AbstractDataFixture
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
}