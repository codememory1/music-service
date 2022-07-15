<?php

namespace App\Service\UserProfileDesign;

use App\DTO\UserProfileDesignDTO;
use App\Entity\UserProfile;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdateUserProfileDesignService.
 *
 * @package App\Service\UserProfileDesign
 *
 * @author  Codememory
 */
class UpdateUserProfileDesignService extends AbstractService
{
    #[Required]
    public ?ImageUploader $imageUploader = null;

    public function make(UserProfileDesignDTO $userProfileDesignDTO, UserProfile $userProfile): JsonResponse
    {
        if (false === $this->validate($userProfileDesignDTO)) {
            return $this->validator->getResponse();
        }

        $userProfileDesignEntity = $userProfileDesignDTO->getEntity();

        $userProfileDesignEntity->setCoverImage($this->uploadImage($userProfileDesignDTO, $userProfile));
        $userProfileDesignEntity->setDesignComponents($userProfileDesignDTO->designComponents);

        $this->em->flush();

        return $this->responseCollection->successUpdate('userProfileDesign@successUpdate');
    }

    private function uploadImage(UserProfileDesignDTO $userProfileDesignDTO, UserProfile $userProfile): ?string
    {
        $coverImage = $userProfileDesignDTO->coverImage;

        $this->imageUploader->setUser($userProfile->getUser());
        $this->imageUploader->setEntity($userProfile->getDesign());

        $this->imageUploader->upload($coverImage->getRealPath(), $coverImage->getMimeType());

        return $this->imageUploader->getUploadedFile()->first();
    }
}