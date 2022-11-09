<?php

namespace App\Service\UserProfileDesign;

use App\Dto\Transfer\UserProfileDesignDto;
use App\Entity\UserProfileDesign;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\FileUploader\Uploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpdateUserProfileDesign
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly Uploader $fileUploader,
        private readonly ImageUploader $imageUploader
    ) {
    }

    public function update(UserProfileDesignDto $dto): UserProfileDesign
    {
        $this->validator->validate($dto);

        $userProfileDesign = $dto->getEntity();

        $userProfileDesign->setCoverImage($this->uploadImage($dto->coverImage, $userProfileDesign));
        $userProfileDesign->setDesignComponents($dto->designComponents);

        $this->flusher->save();

        return $userProfileDesign;
    }

    private function uploadImage(UploadedFile $imageFile, UserProfileDesign $userProfileDesign): ?string
    {
        return $this->fileUploader->simpleUpload(
            $this->imageUploader,
            $userProfileDesign->getCoverImage(),
            $imageFile,
            'cover_image',
            $userProfileDesign
        );
    }
}