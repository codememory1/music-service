<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\RoleRight;
use App\Entity\RoleRightName;
use App\Enums\RoleEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class RoleRightFixtures
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
class RoleRightFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @var array
     */
    private array $roleRights = [
        // Developer
        [
            'right_name' => RoleRightName::ADD_TRACK,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RoleRightName::UPDATE_TRACK,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RoleRightName::DELETE_TRACK,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RoleRightName::CREATE_SUBSCRIPTION,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RoleRightName::UPDATE_SUBSCRIPTION,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RoleRightName::DELETE_SUBSCRIPTION,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RoleRightName::CREATE_LANG,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RoleRightName::UPDATE_LANG,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RoleRightName::DELETE_LANG,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RoleRightName::ADD_TRANSLATION,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RoleRightName::UPDATE_TRANSLATION,
            'role'       => RoleEnum::DEVELOPER
        ],
        [
            'right_name' => RoleRightName::DELETE_TRANSLATION,
            'role'       => RoleEnum::DEVELOPER
        ],

        // Music Manager
        [
            'right_name' => RoleRightName::ADD_TRACK,
            'role'       => RoleEnum::MUSIC_MANAGER
        ],
        [
            'right_name' => RoleRightName::UPDATE_TRACK,
            'role'       => RoleEnum::MUSIC_MANAGER
        ],
        [
            'right_name' => RoleRightName::DELETE_TRACK,
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

        foreach ($this->roleRights as $roleRight) {
            /** @var RoleRightName $roleRightNameEntity */
            $roleRightNameEntity = $this->getReference(sprintf('role-right-name-%s', $roleRight['right_name']));

            /** @var Role $roleEntity */
            $roleEntity = $this->getReference(sprintf('role-%s', $roleRight['role']->value));
            $roleRightEntity = new RoleRight();

            $roleRightEntity
                ->setRoleRightName($roleRightNameEntity)
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
            RoleRightNameFixtures::class,
            RoleFixtures::class
        ];

    }

}
