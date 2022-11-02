<?php

namespace App\Service\UserProfileDesign;

use App\Dto\Transfer\UserProfileDesignDto;
use App\Entity\UserProfileDesign;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\AbstractService;
use App\Service\FileUploader\Uploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class UpdateUserProfileDesignService extends AbstractService
{
    #[Required]
    public ?ImageUploader $imageUploader = null;

    #[Required]
    public ?Uploader $fileUploader = null;

    public function update(UserProfileDesignDto $userProfileDesignDto): UserProfileDesign
    {
        $this->validate($userProfileDesignDto);

        $userProfileDesign = $userProfileDesignDto->getEntity();

        $userProfileDesign->setCoverImage($this->uploadImage($userProfileDesignDto->coverImage, $userProfileDesign));
        $userProfileDesign->setDesignComponents($userProfileDesignDto->designComponents);

        $this->flusherService->save();

        return $userProfileDesign;
    }

    public function request(UserProfileDesignDto $userProfileDesignDto): JsonResponse
    {
        $this->update($userProfileDesignDto);

        return $this->responseCollection->successUpdate('userProfileDesign@successUpdate');
    }

    private function uploadImage(UploadedFile $image, UserProfileDesign $userProfileDesign): ?string
    {
        return $this->fileUploader->simpleUpload(
            $this->imageUploader,
            $userProfileDesign->getCoverImage(),
            $image,
            'cover_image',
            $userProfileDesign
        );
    }
}