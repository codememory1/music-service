<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\BranchFactory;
use App\DataFixtures\Factory\LogicBranchFactory;
use App\Entity\MonetizationBranch;
use App\Entity\SubscriptionPermissionBranch;
use App\Enum\LogicBranchEnum;
use App\Enum\LogicBranchStatusEnum;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Persistence\ObjectManager;

final class LoadBranchDataFixture extends AbstractDataFixture
{
    public function __construct()
    {
        parent::__construct([
            new LogicBranchFactory(LogicBranchEnum::SUBSCRIPTION_PERMISSION, LogicBranchStatusEnum::ENABLED),
            new LogicBranchFactory(LogicBranchEnum::ARTIST_MONETIZATION, LogicBranchStatusEnum::ENABLED),

            new BranchFactory(SubscriptionPermissionBranch::class, SubscriptionPermissionBranch::CHECK_PERMISSIONS_IF_DISABLED, [
                SubscriptionPermissionEnum::USER_SETTING_HIDE_MY_MULTIMEDIA->name
            ]),
            new BranchFactory(MonetizationBranch::class, MonetizationBranch::DISABLED_MONETIZATION_FOR_ARTISTS, [])
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