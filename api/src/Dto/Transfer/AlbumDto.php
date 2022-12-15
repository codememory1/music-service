<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Album;
use App\Entity\AlbumType;
use App\Enum\AlbumStatusEnum;
use App\Enum\RequestTypeEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Album>
 */
final class AlbumDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToEntityConstraint('key')]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'album@typeIsRequired')
    ])]
    public ?AlbumType $type = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'album@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'album@maxTitleLength')
    ])]
    public ?string $title = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'album@descriptionIsRequired'),
        new Assert\Length(max: 255, maxMessage: 'album@maxDescriptionLength')
    ])]
    public ?string $description = null;

    #[DtoConstraints\IgnoreCallSetterConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'album@imageIsRequired'),
        new Assert\Type(UploadedFile::class, message: 'common@onlyOneImage'),
        new Assert\File(
            maxSize: '5M',
            mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            maxSizeMessage: 'album@maxSizeImage',
            mimeTypesMessage: 'common@uploadFileNotImage'
        )
    ])]
    public null|array|UploadedFile $image = null;

    #[DtoConstraints\ToEnumConstraint(AlbumStatusEnum::class)]
    #[DtoConstraints\AllowedCallSetterByRequestTypeConstraint(RequestTypeEnum::ADMIN)]
    #[DtoConstraints\ValidationByRequestTypeConstraint(RequestTypeEnum::ADMIN, [
        new Assert\NotBlank(message: 'common@invalidStatus')
    ])]
    public ?AlbumStatusEnum $status = null;
}