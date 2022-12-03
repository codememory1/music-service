<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\User;
use App\Exception\Http\EntityNotFoundException;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Doctrine\ORM\EntityManagerInterface;

final class MonetizationBranchDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ToEntityCallbackConstraint('callbackIgnoredArtistEntity')]
    public array $ignoredArtists = [];

    public function callbackIgnoredArtistEntity(EntityManagerInterface $manager, mixed $value): array
    {
        $userRepository = $manager->getRepository(User::class);

        foreach ($value as $id) {
            if (0 === preg_match('/^\d+$/', $id)) {
                throw EntityNotFoundException::user(['id' => $id]);
            }

            if (null === $userRepository->find($id)) {
                throw EntityNotFoundException::user(['id' => $id]);
            }
        }

        return $value;
    }
}