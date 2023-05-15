<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\UserProfileDesign;
use App\Validator\Constraints as AppAssert;
use Codememory\Dto\DataTransfer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<UserProfileDesign>
 */
final class UserProfileDesignDto extends DataTransfer
{
    #[DC\IgnoreSetterCall]
    #[DC\Validation([
        new Assert\NotBlank(message: 'userProfileDesign@coverImageIsRequired'),
        new Assert\File(
            maxSize: '10M',
            mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            maxSizeMessage: 'userProfileDesign@maxSizeCoverImage',
            mimeTypesMessage: 'userProfileDesign@uploadFileIsNotCoverImage'
        )
    ])]
    public ?UploadedFile $coverImage = null;

    #[DC\ToType]
    #[DC\Validation([
        new AppAssert\JsonSchema('user_profile_design', message: 'userProfileDesign@invalidDesignComponents')
    ])]
    public array $designComponents = [];
}