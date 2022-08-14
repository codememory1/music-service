<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\UserProfileDesign;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<UserProfileDesign>
 */
final class UserProfileDesignDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'userProfileDesign@coverImageIsRequired')]
    #[Assert\File(
        maxSize: '10M',
        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxSizeMessage: 'userProfileDesign@maxSizeCoverImage',
        mimeTypesMessage: 'userProfileDesign@uploadFileIsNotCoverImage'
    )]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public ?UploadedFile $coverImage = null;

    #[AppAssert\JsonSchema('user_profile_design', message: 'userProfileDesign@invalidDesignComponents')]
    #[DtoConstraints\ToTypeConstraint]
    public array $designComponents = [];
}