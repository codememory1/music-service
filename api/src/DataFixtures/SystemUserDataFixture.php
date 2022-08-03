<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\SystemUserFactory;
use App\Enum\SystemUserEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class SystemUserDataFixture.
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
final class SystemUserDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new SystemUserFactory('Bot', SystemUserEnum::BOT),
            new SystemUserFactory('Support', SystemUserEnum::SUPPORT),
        ]);
    }

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
            RoleDataFixture::class
        ];
    }
}