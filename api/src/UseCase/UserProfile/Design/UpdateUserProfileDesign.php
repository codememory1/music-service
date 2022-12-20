<?php

namespace App\UseCase\UserProfile\Design;

use App\Dto\Transfer\UserProfileDesignDto;
use App\Entity\UserProfileDesign;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Service\UserProfile\Design\UpsertUserProfileDesignFile;

final class UpdateUserProfileDesign
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly UpsertUserProfileDesignFile $upsertUserProfileDesignFile
    ) {
    }

    public function process(UserProfileDesignDto $dto): UserProfileDesign
    {
        $this->validator->validate($dto);

        $userProfileDesign = $dto->getEntity();

        $userProfileDesign->setCoverImage($this->upsertUserProfileDesignFile->uploadCoverImage($dto->coverImage, $userProfileDesign));
        $userProfileDesign->setDesignComponents($dto->designComponents);

        $this->flusher->save();

        return $userProfileDesign;
    }
}