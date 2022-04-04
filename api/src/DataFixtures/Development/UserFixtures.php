<?php

namespace App\DataFixtures\Development;

use App\DataFixtures\RoleFixtures;
use App\Entity\Role;
use App\Entity\User;
use App\Enum\RoleEnum;
use App\Enum\StatusEnum;
use App\Service\HashingService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class UserFixtures.
 *
 * @package App\DataFixtures\Development
 *
 * @author  Codememory
 */
class UserFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var array
     */
    private array $users = [
        [
            'email' => 'user@gmail.com',
            'password' => 'passwd',
            'role' => RoleEnum::USER
        ],
        [
            'email' => 'admin@gmail.com',
            'password' => 'passwd',
            'role' => RoleEnum::ADMIN
        ],
        [
            'email' => 'developer@gmail.com',
            'password' => 'passwd',
            'role' => RoleEnum::DEVELOPER
        ],
        [
            'email' => 'music-manager@gmail.com',
            'password' => 'passwd',
            'role' => RoleEnum::MUSIC_MANAGER
        ],
        [
            'email' => 'support@gmail.com',
            'password' => 'passwd',
            'role' => RoleEnum::SUPPORT
        ]
    ];

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->users as $user) {
            /** @var Role $role */
            $role = $this->getReference(sprintf('role-%s', $user['role']->value));
            $userEntity = new User();

            $userEntity
                ->setEmail($user['email'])
                ->setUsername(explode('@', $user['email'])[0])
                ->setPassword((new HashingService())->encode($user['password']))
                ->setStatus(StatusEnum::ACTIVE->value)
                ->setRole($role);

            $manager->persist($userEntity);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [
            RoleFixtures::class
        ];
    }
}