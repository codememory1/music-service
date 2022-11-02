<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Album;
use App\Entity\AlbumType;
use App\Enum\AlbumStatusEnum;
use App\Enum\RequestTypeEnum;
use App\Infrastucture\Dto\AbstractDataTransfer;
use App\Rest\Http\Request;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\DependencyInjection\ReverseContainer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Album>
 */
final class AlbumDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'album@typeIsRequired')]
    #[DtoConstraints\ToEntityConstraint('key')]
    public ?AlbumType $type = null;

    #[Assert\NotBlank(message: 'album@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'album@maxTitleLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;

    #[Assert\NotBlank(message: 'album@descriptionIsRequired')]
    #[Assert\Length(max: 255, maxMessage: 'album@maxDescriptionLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $description = null;

    #[Assert\NotBlank(message: 'album@imageIsRequired')]
    #[Assert\Type(UploadedFile::class, message: 'common@onlyOneImage')]
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxSizeMessage: 'album@maxSizeImage',
        mimeTypesMessage: 'common@uploadFileNotImage'
    )]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public null|array|UploadedFile $image = null;

    #[AppAssert\Condition('callbackStatus', [
        new Assert\NotBlank(message: 'common@invalidStatus')
    ])]
    #[DtoConstraints\ToEnumConstraint(AlbumStatusEnum::class)]
    #[DtoConstraints\AllowedCallSetterByRequestTypeConstraint(RequestTypeEnum::ADMIN)]
    public ?AlbumStatusEnum $status = null;
    private ?string $requestType;

    public function __construct(ReverseContainer $container, Request $request)
    {
        parent::__construct($container);

        $this->requestType = $request->getRequestType();
    }

    public function callbackStatus(): bool
    {
        return $this->requestType === RequestTypeEnum::ADMIN->value;
    }
}