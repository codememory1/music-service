<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\MediaLibrary;
use App\Enum\MediaLibraryStatusEnum;
use App\Infrastucture\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<MediaLibrary>
 */
final class MediaLibraryDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'mediaLibrary@invalidStatus')]
    #[DtoConstraints\ToEnumConstraint(MediaLibraryStatusEnum::class)]
    public ?MediaLibraryStatusEnum $status = null;
}