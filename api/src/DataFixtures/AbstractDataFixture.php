<?php

namespace App\DataFixtures;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @template Entity as mixed
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