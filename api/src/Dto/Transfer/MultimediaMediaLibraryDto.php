<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\MultimediaMediaLibrary;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MultimediaMediaLibraryDto.
 *
 * @package App\Dto\Transfer
 * @template-extends AbstractDataTransfer<MultimediaMediaLibrary>
 *
 * @author  Codememory
 */
final class MultimediaMediaLibraryDto extends AbstractDataTransfer
{
    #[Assert\Length(max: 50, maxMessage: 'multimedia@titleMaxLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;

    #[Assert\AtLeastOneOf([
        new Assert\IsNull(),
        new Assert\File(
            maxSize: '5M',
            mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            maxSizeMessage: 'multimedia@maxSizePreview',
            mimeTypesMessage: 'multimedia@uploadFileIsNotPreview'
        )
    ])]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public ?UploadedFile $image = null;
}