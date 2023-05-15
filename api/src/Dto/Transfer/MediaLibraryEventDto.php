<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Dto\Transfer\Traits\EventPayloadTrait;
use App\Entity\MediaLibraryEvent;
use App\Enum\Interfaces\EventInterface;
use App\Enum\MediaLibraryEventEnum;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<MediaLibraryEvent>
 */
final class MediaLibraryEventDto extends DataTransfer
{
    use EventPayloadTrait;

    #[DC\ToEnum(MediaLibraryEventEnum::class)]
    #[DC\Validation([
        new Assert\NotBlank(message: 'event@keyIsRequired')
    ])]
    public ?EventInterface $key = null;
}