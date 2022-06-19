<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\RoleFactory;
use App\Entity\Role;
use App\Enum\RoleEnum;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class RoleDataFixture.
 *
 * @package App\DataFixtures
 * @template-extends AbstractDataFixture<Role>
 *
 * @author  Codememory
 */
final class RoleDataFixture extends AbstractDataFixture implements DependentFixtureInterface, FixtureGroupInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new RoleFactory(RoleEnum::FOUNDER, 'role@founder', 'role@founderDescription'),
            new RoleFactory(RoleEnum::DEVELOPER, 'role@developer', 'role@developerDescription'),
            new RoleFactory(RoleEnum::ADMIN, 'role@admin', 'role@adminDescription'),
            new RoleFactory(RoleEnum::SUPPORT, 'role@support', 'role@supportDescription'),
            new RoleFactory(RoleEnum::MUSIC_MANAGER, 'role@musicManager', 'role@musicManagerDescription'),
            new RoleFactory(RoleEnum::USER, 'role@user', 'role@userDescription'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("r-{$entity->getKey()}", $entity);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [
            TranslationDataFixture::class
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getGroups(): array
    {
        return [
            'user'
        ];
    }
}