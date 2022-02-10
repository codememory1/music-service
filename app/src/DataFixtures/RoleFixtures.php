<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Enum\RoleEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class RoleFixtures
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
class RoleFixtures extends Fixture
{

    /**
     * @var array
     */
    private array $roles = [
        [
            'key'   => RoleEnum::USER,
            'title' => 'rule@user'
        ],
        [
            'key'   => RoleEnum::DEVELOPER,
            'title' => 'rule@developer'
        ],
        [
            'key'   => RoleEnum::ADMIN,
            'title' => 'rule@admin'
        ],
        [
            'key'   => RoleEnum::MUSIC_MANAGER,
            'title' => 'rule@musicManager'
        ],
        [
            'key'   => RoleEnum::SUPPORT,
            'title' => 'rule@support'
        ]
    ];

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        foreach ($this->roles as $role) {
            $roleEntity = new Role();

            $roleEntity
                ->setKey($role['key']->value)
                ->setTitleTranslationKey($role['title']);

            $this->addReference(sprintf('role-%s', $role['key']->value), $roleEntity);

            $manager->persist($roleEntity);
        }

        $manager->flush();

    }


}
