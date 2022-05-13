<?php

namespace App\DataFixtures;

use App\DataFixtures\Templates\TranslationKeyDataFixtureTemplate;
use App\Entity\TranslationKey;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class TranslationKeyDataFixture.
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
final class TranslationKeyDataFixture extends AbstractDataFixture
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new TranslationKeyDataFixtureTemplate('entityNotFound@page'),
            new TranslationKeyDataFixtureTemplate('entityNotFound@language'),
            new TranslationKeyDataFixtureTemplate('entityNotFound@translationKey'),
            new TranslationKeyDataFixtureTemplate('entityNotFound@translation'),

            new TranslationKeyDataFixtureTemplate('auth@successAuthorization'),

            new TranslationKeyDataFixtureTemplate('registration@successRegistration'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        /** @var TranslationKey $entity */
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("tk-{$entity->getKey()}", $entity);
        }

        $manager->flush();
    }
}