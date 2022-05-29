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
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::VIEW_LANGUAGES_WITH_FULL_INFO),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_LANGUAGE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_LANGUAGE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_LANGUAGE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::SHOW_ROLES),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::CREATE_USER_ROLE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::UPDATE_USER_ROLE),
            new RolePermissionFactory(RoleEnum::DEVELOPER, RolePermissionEnum::DELETE_USER_ROLE),
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