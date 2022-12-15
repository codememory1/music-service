<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Playlist;
use App\Enum\PlaylistStatusEnum;
use App\Enum\RequestTypeEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Playlist>
 */
final class PlaylistDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'playlist@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'playlist@titleMaxLength')
    ])]
    public ?string $title = null;

    #[DtoConstraints\ValidationConstraint([
        new AppAssert\Condition('callbackImage', [
            new Assert\File(
                maxSize: '5M',
                mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
                maxSizeMessage: 'playlist@maxSizeImage',
                mimeTypesMessage: 'common@uploadFileNotImage'
            )
        ])
    ])]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public ?UploadedFile $image = null;

    #[DtoConstraints\ToEnumConstraint(PlaylistStatusEnum::class)]
    #[DtoConstraints\AllowedCallSetterByRequestTypeConstraint(RequestTypeEnum::ADMIN)]
    #[DtoConstraints\ValidationByRequestTypeConstraint(RequestTypeEnum::ADMIN, [
        new Assert\NotBlank(message: 'common@invalidStatus')
    ])]
    public ?PlaylistStatusEnum $status = null;

    public function callbackImage(): bool
    {
        return false === empty($this->image);
    }
}