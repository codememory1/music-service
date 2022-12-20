<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\LogicBranch;
use App\Enum\LogicBranchEnum;
use App\Enum\LogicBranchStatusEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class LogicBranchFactory implements DataFixtureFactoryInterface
{
    public function __construct(
        private readonly LogicBranchEnum $branch,
        private readonly LogicBranchStatusEnum $status
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        $logicBranch = new LogicBranch();

        $logicBranch->setName($this->branch);
        $logicBranch->setStatus($this->status);

        return $logicBranch;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}