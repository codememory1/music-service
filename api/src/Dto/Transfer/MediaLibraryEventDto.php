<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Traits\EventPayloadTrait;
use App\Entity\MediaLibraryEvent;
use App\Enum\Interfaces\EventInterface;
use App\Enum\MediaLibraryEventEnum;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MediaLibraryEventDto.
 *
 * @package App\Dto\Transfer
 * @template-extends AbstractDataTransfer<MediaLibraryEvent>
 *
 * @author  Codememory
 */
final class MediaLibraryEventDto extends AbstractDataTransfer
{
    use EventPayloadTrait;

    #[Assert\NotBlank(message: 'event@keyIsRequired')]
    #[DtoConstraints\ToEnumConstraint(MediaLibraryEventEnum::class)]
    public ?EventInterface $key = null;
}