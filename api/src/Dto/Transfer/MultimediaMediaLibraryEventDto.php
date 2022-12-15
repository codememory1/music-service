<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Transfer\Traits\EventPayloadTrait;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Enum\Interfaces\EventInterface;
use App\Enum\MultimediaMediaLibraryEventEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<MultimediaMediaLibraryEvent>
 */
final class MultimediaMediaLibraryEventDto extends AbstractDataTransfer
{
    use EventPayloadTrait;

    #[DtoConstraints\ToEnumConstraint(MultimediaMediaLibraryEventEnum::class)]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'event@keyIsRequired')
    ])]
    public ?EventInterface $key = null;
}