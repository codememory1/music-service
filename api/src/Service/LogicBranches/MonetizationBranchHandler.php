<?php

namespace App\Service\LogicBranches;

use App\Entity\MonetizationBranch;
use App\Entity\User;
use App\Enum\LogicBranchEnum;
use App\Repository\LogicBranchRepository;
use App\Repository\MonetizationBranchRepository;

final class MonetizationBranchHandler
{
    public function __construct(
        private readonly LogicBranchRepository $logicBranchRepository,
        private readonly MonetizationBranchRepository $monetizationBranchRepository
    ) {
    }

    public function isAllowed(User $user): bool
    {
        $logicBranch = $this->logicBranchRepository->findByName(LogicBranchEnum::ARTIST_MONETIZATION);
        $artistsWithDisabledMonetization = $this->monetizationBranchRepository->findByKey(MonetizationBranch::DISABLED_MONETIZATION_FOR_ARTISTS);

        return $logicBranch->isEnabled() && !$artistsWithDisabledMonetization->existToDisabled($user);
    }
}