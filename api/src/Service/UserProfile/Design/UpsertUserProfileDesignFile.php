<?php

namespace App\Service\UserProfile\Design;

use App\Entity\UserProfileDesign;
use App\Rest\S3\Uploader\ImageUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpsertUserProfileDesignFile
{
    public function __construct(
        private readonly ImageUploader $imageUploader
    ) {
    }

    public function uploadCoverImage(UploadedFile $file, UserProfileDesign $userProfileDesign): string
    {
        $this->imageUploader->save($userProfileDesign->getCoverImage(), $file, 'coverImage', $userProfileDesign);

        return $this->imageUploader->getUploadedFile()->first();
    }
}