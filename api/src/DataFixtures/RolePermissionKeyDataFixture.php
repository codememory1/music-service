<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\RolePermissionKeyFactory;
use App\Entity\RolePermissionKey;
use App\Enum\RolePermissionEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class RolePermissionKeyDataFixture.
 *
 * @package App\DataFixtures
 * @template-extends AbstractDataFixture<RolePermissionKey>
 *
 * @author  Codememory
 */
final class RolePermissionKeyDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new RolePermissionKeyFactory(RolePermissionEnum::CREATE_LANGUAGE, 'rolePermission@createLanguage')
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("rpk-{$entity->getKey()}", $entity);
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
}