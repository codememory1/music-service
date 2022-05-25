<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\RolePermissionFactory;
use App\Entity\RolePermission;
use App\Enum\RoleEnum;
use App\Enum\RolePermissionEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class RolePermissionDataFixture.
 *
 * @package App\DataFixtures
 * @template-extends AbstractDataFixture<RolePermission>
 *
 * @author  Codememory
 */
final class RolePermissionDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_LANGUAGE)
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [
            RoleDataFixture::class,
            RolePermissionKeyDataFixture::class
        ];
    }
}