<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Transfer\Traits\EventPayloadTrait;
use App\Entity\MediaLibraryEvent;
use App\Enum\Interfaces\EventInterface;
use App\Enum\MediaLibraryEventEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<MediaLibraryEvent>
 */
final class MediaLibraryEventDto extends AbstractDataTransfer
{
    use EventPayloadTrait;

    #[Assert\NotBlank(message: 'event@keyIsRequired')]
    #[DtoConstraints\ToEnumConstraint(MediaLibraryEventEnum::class)]
    public ?EventInterface $key = null;
}