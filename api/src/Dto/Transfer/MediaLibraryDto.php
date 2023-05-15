<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\MediaLibrary;
use App\Enum\MediaLibraryStatusEnum;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<MediaLibrary>
 */
final class MediaLibraryDto extends DataTransfer
{
    #[DC\ToEnum]
    #[DC\Validation([
        new Assert\NotBlank(message: 'mediaLibrary@invalidStatus')
    ])]
    public ?MediaLibraryStatusEnum $status = null;
}