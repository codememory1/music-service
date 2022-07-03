<?php

namespace App\Event;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;

/**
 * Class MultimediaStatusChangeEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class MultimediaStatusChangeEvent
{
    public readonly Multimedia $multimedia;
    public readonly MultimediaStatusEnum $onStatus;

    public function __construct(Multimedia $multimedia, MultimediaStatusEnum $onStatus)
    {
        $this->multimedia = $multimedia;
        $this->onStatus = $onStatus;
    }
}