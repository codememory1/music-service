<?php

namespace App\Service\LogicBranches;

use App\Entity\MonetizationBranch;
use App\Entity\User;
use App\Enum\LogicBranchEnum;
use App\Enum\LogicBranchStatusEnum;
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
        $ignoredArtist = $this->monetizationBranchRepository->findByKey(MonetizationBranch::IGNORED_ARTISTS_KEY);

        return $logicBranch->getStatus() === LogicBranchStatusEnum::ENABLED->name && !in_array($user->getId(), $ignoredArtist->getValue(), true);
    }
}