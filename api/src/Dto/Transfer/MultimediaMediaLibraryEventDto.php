<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Traits\EventPayloadTrait;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Enum\Interfaces\EventInterface;
use App\Enum\MultimediaMediaLibraryEventEnum;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MultimediaMediaLibraryEventDto.
 *
 * @package App\Dto\Transfer
 * @template-extends AbstractDataTransfer<MultimediaMediaLibraryEvent>
 *
 * @author  Codememory
 */
final class MultimediaMediaLibraryEventDto extends AbstractDataTransfer
{
    use EventPayloadTrait;

    #[Assert\NotBlank(message: 'event@keyIsRequired')]
    #[DtoConstraints\ToEnumConstraint(MultimediaMediaLibraryEventEnum::class)]
    public ?EventInterface $key = null;
}