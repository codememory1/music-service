<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\BranchFactory;
use App\DataFixtures\Factory\LogicBranchFactory;
use App\Entity\MonetizationBranch;
use App\Entity\SubscriptionPermissionBranch;
use App\Enum\LogicBranchEnum;
use App\Enum\LogicBranchStatusEnum;
use Doctrine\Persistence\ObjectManager;

final class LoadBranchDataFixture extends AbstractDataFixture
{
    public function __construct()
    {
        parent::__construct([
            new LogicBranchFactory(LogicBranchEnum::SUBSCRIPTION_PERMISSION, LogicBranchStatusEnum::ENABLED),
            new LogicBranchFactory(LogicBranchEnum::ARTIST_MONETIZATION, LogicBranchStatusEnum::ENABLED),

            new BranchFactory(SubscriptionPermissionBranch::class, SubscriptionPermissionBranch::IGNORED_PERMISSIONS_KEY, []),
            new BranchFactory(MonetizationBranch::class, MonetizationBranch::IGNORED_ARTISTS_KEY, [])
        ]);
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }
}