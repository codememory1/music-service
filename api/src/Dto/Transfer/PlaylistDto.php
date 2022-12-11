<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Playlist;
use App\Enum\PlaylistStatusEnum;
use App\Enum\RequestTypeEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Rest\Http\Request;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\DependencyInjection\ReverseContainer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Playlist>
 */
final class PlaylistDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'playlist@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'playlist@titleMaxLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;

    #[AppAssert\Condition('callbackImage', [
        new Assert\File(
            maxSize: '5M',
            mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            maxSizeMessage: 'playlist@maxSizeImage',
            mimeTypesMessage: 'common@uploadFileNotImage'
        )
    ])]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public ?UploadedFile $image = null;

    #[AppAssert\Condition('callbackStatus', [
        new Assert\NotBlank(message: 'common@invalidStatus')
    ])]
    #[DtoConstraints\ToEnumConstraint(PlaylistStatusEnum::class)]
    #[DtoConstraints\AllowedCallSetterByRequestTypeConstraint(RequestTypeEnum::ADMIN)]
    public ?PlaylistStatusEnum $status = null;
    private Request $request;

    public function __construct(ReverseContainer $container, Request $request)
    {
        parent::__construct($container);

        $this->request = $request;
    }

    public function callbackImage(): bool
    {
        return false === empty($this->image);
    }

    public function callbackStatus(): bool
    {
        return $this->request->getRequestType() === RequestTypeEnum::ADMIN->value;
    }
}