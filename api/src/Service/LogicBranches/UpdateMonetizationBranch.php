<?php

namespace App\Service\LogicBranches;

use App\Dto\Transfer\MonetizationBranchDto;
use App\Entity\MonetizationBranch;
use App\Infrastructure\Validator\Validator;
use App\Repository\MonetizationBranchRepository;
use Doctrine\ORM\EntityManagerInterface;

final class UpdateMonetizationBranch
{
    public function __construct(
        private readonly Validator $validator,
        private readonly EntityManagerInterface $em,
        private readonly MonetizationBranchRepository $monetizationBranchRepository
    ) {
    }

    public function update(MonetizationBranchDto $dto): void
    {
        $this->validator->validate($dto);

        $this->updateIgnoredArtists($dto->ignoredArtists);

        $this->em->flush();
    }

    public function updateIgnoredArtists(array $artists): MonetizationBranch
    {
        $ignoredArtist = $this->monetizationBranchRepository->findByKey(MonetizationBranch::IGNORED_ARTISTS_KEY);

        $ignoredArtist->setValue($artists);

        return $ignoredArtist;
    }
}