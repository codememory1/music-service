<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\AlbumType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DtoForDebug.
 *
 * @package App\Dto\Transfer
 *
 * @author  Codememory
 */
class DtoForDebug extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'album@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'album@maxTitleLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;

    #[Assert\NotBlank(message: 'album@descriptionIsRequired')]
    #[Assert\Length(max: 255, maxMessage: 'album@maxDescriptionLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $description = null;

    #[Assert\NotBlank(message: 'album@imageIsRequired')]
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxSizeMessage: 'album@maxSizeImage',
        mimeTypesMessage: 'common@uploadFileNotImage'
    )]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public ?UploadedFile $image = null;

    #[Assert\NotBlank(message: 'album@typeIsRequired')]
    #[DtoConstraints\ToEntityConstraint('key')]
    public ?AlbumType $type = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public ?array $arr = [];
}