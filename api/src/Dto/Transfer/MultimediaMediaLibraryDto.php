<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\MultimediaMediaLibrary;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<MultimediaMediaLibrary>
 */
final class MultimediaMediaLibraryDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\Length(max: 50, maxMessage: 'multimedia@titleMaxLength')
    ])]
    public ?string $title = null;

    #[DtoConstraints\IgnoreCallSetterConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\AtLeastOneOf([
            new Assert\IsNull(),
            new Assert\File(
                maxSize: '5M',
                mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
                maxSizeMessage: 'multimedia@maxSizePreview',
                mimeTypesMessage: 'multimedia@uploadFileIsNotPreview'
            )
        ])
    ])]
    public ?UploadedFile $image = null;
}