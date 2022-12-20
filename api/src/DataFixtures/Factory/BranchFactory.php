<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\BranchInterface;
use App\Entity\Interfaces\EntityInterface;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class BranchFactory implements DataFixtureFactoryInterface
{
    public function __construct(
        private readonly string $branchEntity,
        private readonly string $key,
        private readonly array $value
    ) {
    }

    /**
     * @return BranchInterface
     */
    public function factoryMethod(): EntityInterface
    {
        $branch = new ($this->branchEntity)();

        $branch->setKey($this->key);
        $branch->setValue($this->value);

        return $branch;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}