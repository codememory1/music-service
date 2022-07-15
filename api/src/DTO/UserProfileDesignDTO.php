<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\UserProfileDesign;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserProfileDesignDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<UserProfileDesign>
 *
 * @author  Codememory
 */
class UserProfileDesignDTO extends AbstractDTO
{
    protected EntityInterface|string|null $entity = UserProfileDesign::class;

    #[Assert\NotBlank(message: 'userProfileDesign@coverImageIsRequired')]
    #[Assert\File(
        maxSize: '10M',
        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxSizeMessage: 'userProfileDesign@maxSizeCoverImage',
        mimeTypesMessage: 'userProfileDesign@uploadFileIsNotCoverImage'
    )]
    public ?UploadedFile $coverImage = null;

    #[AppAssert\JsonSchema('user_profile_design', message: 'userProfileDesign@invalidDesignComponents')]
    public array $designComponents = [];

    protected function wrapper(): void
    {
        $this->coverImage = $this->request?->request->files->get('cover_image');

        $this->addExpectKey('design_components', 'designComponents');

        $this->addInterceptor('designComponents', new AsArrayInterceptor());
    }
}