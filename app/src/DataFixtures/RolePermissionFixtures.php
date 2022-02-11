<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\RolePermission;
use App\Entity\RolePermissionName;
use App\Enum\RoleEnum;
use App\Enum\RolePermissionNameEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class RolePermissionFixtures
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
class RolePermissionFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @var array
     */
    private array $rolePermissions = [
        // Developer
        [
            'right_name' => RolePermissionNameEnum::ADD_TRACK,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RolePermissionNameEnum::UPDATE_TRACK,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RolePermissionNameEnum::DELETE_TRACK,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RolePermissionNameEnum::CREATE_SUBSCRIPTION,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RolePermissionNameEnum::UPDATE_SUBSCRIPTION,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RolePermissionNameEnum::DELETE_SUBSCRIPTION,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RolePermissionNameEnum::CREATE_LANG,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RolePermissionNameEnum::UPDATE_LANG,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RolePermissionNameEnum::DELETE_LANG,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RolePermissionNameEnum::CREATE_TRANSLATION,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RolePermissionNameEnum::UPDATE_TRANSLATION,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RolePermissionNameEnum::DELETE_TRANSLATION,
            'role'       => RoleEnum::DEVELOPER
        ],

        // Music Manager
        [
            'right_name' => RolePermissionNameEnum::ADD_TRACK,
            'role'       => RoleEnum::MUSIC_MANAGER
        ],
        [
            'right_name' => RolePermissionNameEnum::UPDATE_TRACK,
            'role'       => RoleEnum::MUSIC_MANAGER
        ],
        [
            'right_name' => RolePermissionNameEnum::DELETE_TRACK,
            'role'       => RoleEnum::MUSIC_MANAGER
        ]
    ];

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        foreach ($this->rolePermissions as $rolePermission) {
            /** @var RolePermissionName $rolePermissionNameEntity */
            $rolePermissionNameEntity = $this->getReference(sprintf('role-right-name-%s', $rolePermission['right_name']->value));

            /** @var Role $roleEntity */
            $roleEntity = $this->getReference(sprintf('role-%s', $rolePermission['role']->value));
            $roleRightEntity = new RolePermission();

            $roleRightEntity
                ->setRolePermissionName($rolePermissionNameEntity)
                ->setRole($roleEntity);

            $manager->persist($roleRightEntity);
        }

        $manager->flush();

    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {

        return [
            RolePermissionNameFixtures::class,
            RoleFixtures::class
        ];

    }

}
