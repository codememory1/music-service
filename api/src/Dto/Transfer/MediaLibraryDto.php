<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\MediaLibrary;
use App\Enum\MediaLibraryStatusEnum;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MediaLibraryDto.
 *
 * @package App\Dto\Transfer
 * @template-extends AbstractDataTransfer<MediaLibrary>
 *
 * @author  Codememory
 */
final class MediaLibraryDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'mediaLibrary@invalidStatus')]
    #[DtoConstraints\ToEnumConstraint(MediaLibraryStatusEnum::class)]
    public ?MediaLibraryStatusEnum $status = null;
}