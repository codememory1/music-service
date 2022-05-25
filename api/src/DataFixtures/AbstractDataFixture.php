<?php

namespace App\DataFixtures;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AbstractDataFixture.
 *
 * @package App\DataFixtures
 * @template Entity as mixed
 *
 * @author  Codememory
 */
abstract class AbstractDataFixture extends Fixture
{
    /**
     * @var array<DataFixtureFactoryInterface>
     */
    protected array $factories;

    /**
     * @param array<DataFixtureFactoryInterface> $factories
     */
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    abstract public function load(ObjectManager $manager): void;

    /**
     * @return array<Entity>
     */
    protected function getEntities(): array
    {
        $entities = [];

        foreach ($this->factories as $factory) {
            $factory->setReferenceRepository($this->referenceRepository);

            $entities[] = $factory->factoryMethod();
        }

        return $entities;
    }
}