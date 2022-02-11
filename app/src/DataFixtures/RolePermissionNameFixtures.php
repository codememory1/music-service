<?php

namespace App\DataFixtures;

use App\Entity\RolePermissionName;
use App\Enum\RolePermissionNameEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class RolePermissionNameFixtures
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
class RolePermissionNameFixtures extends Fixture
{

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        foreach (RolePermissionNameEnum::values() as $rolePermissionName => $titleTranslationKey) {
            $rolePermissionNameEntity = new RolePermissionName();

            $rolePermissionNameEntity
                ->setKey($rolePermissionName)
                ->setTitleTranslationKey($titleTranslationKey);

            $this->addReference(sprintf('role-right-name-%s', $rolePermissionName), $rolePermissionNameEntity);

            $manager->persist($rolePermissionNameEntity);
        }

        $manager->flush();

    }

}
