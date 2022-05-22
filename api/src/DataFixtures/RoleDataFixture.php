<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\RoleFactory;
use App\Entity\Role;
use App\Enum\RoleEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class RoleDataFixture.
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
final class RoleDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    #[Pure]
    protected function __construct()
    {
        parent::__construct([
            new RoleFactory(RoleEnum::DEVELOPER, 'role@developer', 'role@developerDescription')
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        /** @var Role $entity */
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("r-{$entity->getKey()}", $entity);
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