<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Infrastructure\Dto\Constraints as ADC;
use App\Entity\Playlist;
use App\Enum\PlaylistStatusEnum;
use App\Enum\RequestTypeEnum;
use App\Validator\Constraints as AppAssert;
use Codememory\Dto\DataTransfer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<Playlist>
 */
final class PlaylistDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'playlist@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'playlist@titleMaxLength')
    ])]
    public ?string $title = null;

    #[DC\Validation([
        new AppAssert\Condition('callbackImage', [
            new Assert\File(
                maxSize: '5M',
                mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
                maxSizeMessage: 'playlist@maxSizeImage',
                mimeTypesMessage: 'common@uploadFileNotImage'
            )
        ])
    ])]
    #[DC\IgnoreSetterCall]
    public ?UploadedFile $image = null;

    #[DC\ToEnum]
    #[ADC\SetterCallByRequestType(RequestTypeEnum::ADMIN)]
    #[ADC\ValidationByRequestType(RequestTypeEnum::ADMIN, [
        new Assert\NotBlank(message: 'common@invalidStatus')
    ])]
    public ?PlaylistStatusEnum $status = null;

    public function callbackImage(): bool
    {
        return false === empty($this->image);
    }
}