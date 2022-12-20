<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\UserProfileDesign;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<UserProfileDesign>
 */
final class UserProfileDesignDto extends AbstractDataTransfer
{
    #[DtoConstraints\IgnoreCallSetterConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'userProfileDesign@coverImageIsRequired'),
        new Assert\File(
            maxSize: '10M',
            mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            maxSizeMessage: 'userProfileDesign@maxSizeCoverImage',
            mimeTypesMessage: 'userProfileDesign@uploadFileIsNotCoverImage'
        )
    ])]
    public ?UploadedFile $coverImage = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new AppAssert\JsonSchema('user_profile_design', message: 'userProfileDesign@invalidDesignComponents')
    ])]
    public array $designComponents = [];
}