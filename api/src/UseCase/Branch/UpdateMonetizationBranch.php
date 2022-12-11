<?php

namespace App\UseCase\Branch;

use App\Dto\Transfer\MonetizationBranchDto;
use App\Entity\MonetizationBranch;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Repository\MonetizationBranchRepository;

final class UpdateMonetizationBranch
{
    public function __construct(
        private readonly Validator $validator,
        private readonly Flusher $flusher,
        private readonly MonetizationBranchRepository $monetizationBranchRepository
    ) {
    }

    public function process(MonetizationBranchDto $dto): void
    {
        $this->validator->validate($dto);

        $this->updateIgnoredArtists($dto->ignoredArtists);

        $this->flusher->save();
    }

    public function updateIgnoredArtists(array $artists): MonetizationBranch
    {
        $ignoredArtist = $this->monetizationBranchRepository->findByKey(MonetizationBranch::IGNORED_ARTISTS_KEY);

        $ignoredArtist->setValue($artists);

        return $ignoredArtist;
    }
}