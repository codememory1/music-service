<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\UserFactory;
use App\Entity\User;
use App\Enum\RoleEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class UserDataFixture.
 *
 * @package App\DataFixtures
 * @template-extends AbstractDataFixture<User>
 *
 * @author  Codememory
 */
final class UserDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new UserFactory('Founder', 'founder@gmail.com', 'founder', RoleEnum::FOUNDER),
            new UserFactory('Developer', 'developer@gmail.com', 'developer', RoleEnum::DEVELOPER),
            new UserFactory('Admin', 'admin@gmail.com', 'admin', RoleEnum::ADMIN),
            new UserFactory('Support', 'support@gmail.com', 'founder', RoleEnum::SUPPORT),
            new UserFactory('Music Manager', 'music-manager@gmail.com', 'music_manager', RoleEnum::MUSIC_MANAGER),
            new UserFactory('User', 'user@gmail.com', 'user', RoleEnum::USER),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("u-{$entity->getEmail()}", $entity);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [
            RoleDataFixture::class
        ];
    }
}