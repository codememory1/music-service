<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\MediaLibrary;
use App\Enum\MediaLibraryStatusEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<MediaLibrary>
 */
final class MediaLibraryDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToEnumConstraint(MediaLibraryStatusEnum::class)]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'mediaLibrary@invalidStatus')
    ])]
    public ?MediaLibraryStatusEnum $status = null;
}