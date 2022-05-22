<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\TranslationKeyFactory;
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
            new TranslationKeyFactory('common@incorrectEmail'),
            new TranslationKeyFactory('common@passwordIsRequired'),

            new TranslationKeyFactory('entityNotFound@page'),
            new TranslationKeyFactory('entityNotFound@language'),
            new TranslationKeyFactory('entityNotFound@translationKey'),
            new TranslationKeyFactory('entityNotFound@translation'),

            new TranslationKeyFactory('auth@successAuthorization'),

            new TranslationKeyFactory('registration@successRegistration'),
            new TranslationKeyFactory('registration@incorrectPassword'),
            new TranslationKeyFactory('registration@minPasswordLength'),
            new TranslationKeyFactory('registration@invalidConfirmPassword'),
            new TranslationKeyFactory('registration@registration'),

            new TranslationKeyFactory('userProfile@pseudonymIsRequired'),
            new TranslationKeyFactory('userProfile@maxPseudonymLength'),

            new TranslationKeyFactory('language@minCodeLength'),
            new TranslationKeyFactory('language@maxCodeLength'),
            new TranslationKeyFactory('language@originalTitleIsRequired'),
            new TranslationKeyFactory('language@successCreate'),
            new TranslationKeyFactory('language@successUpdate'),
            new TranslationKeyFactory('language@successDelete'),
            new TranslationKeyFactory('language@codeExist'),

            new TranslationKeyFactory('user@existByEmail'),

            new TranslationKeyFactory('userProfile@existByUser'),

            new TranslationKeyFactory('rolePermission@createLanguage'),

            new TranslationKeyFactory('role@developer'),
            new TranslationKeyFactory('role@developerDescription'),
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