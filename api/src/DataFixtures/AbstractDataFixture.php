<?php

namespace App\DataFixtures;

use App\DataFixtures\Interfaces\DataFixtureTemplateInterface;
use App\Entity\Interfaces\EntityInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AbstractDataFixture
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
abstract class AbstractDataFixture extends Fixture
{
    /**
     * @var array<DataFixtureTemplateInterface>
     */
    protected array $templates;

    /**
     * @param array<DataFixtureTemplateInterface> $templates
     */
    protected function __construct(array $templates)
    {
        $this->templates = $templates;
    }

    /**
     * @return EntityInterface[]
     */
    protected function getEntities(): array
    {
        $entities = [];
        
        foreach ($this->templates as $template) {
            $template->setReferenceRepository($this->referenceRepository);

            $entities[] = $template->getEntity();
        }

        return $entities;
    }

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    abstract public function load(ObjectManager $manager): void;
}