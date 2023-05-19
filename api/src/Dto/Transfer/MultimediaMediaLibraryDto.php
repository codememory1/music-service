<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\MultimediaMediaLibrary;
use Codememory\Dto\DataTransfer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<MultimediaMediaLibrary>
 */
final class MultimediaMediaLibraryDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\Length(max: 50, maxMessage: 'multimedia@titleMaxLength')
    ])]
    public ?string $title = null;

    #[DC\IgnoreSetterCall]
    #[DC\Validation([
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