<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Dto\Transfer\Traits\EventPayloadTrait;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Enum\Interfaces\EventInterface;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<MultimediaMediaLibraryEvent>
 */
final class MultimediaMediaLibraryEventDto extends DataTransfer
{
    use EventPayloadTrait;

    #[DC\ToEnum]
    #[DC\Validation([
        new Assert\NotBlank(message: 'event@keyIsRequired')
    ])]
    public ?EventInterface $key = null;
}