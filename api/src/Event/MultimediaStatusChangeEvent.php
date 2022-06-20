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
    /**
     * @var Multimedia
     */
    public readonly Multimedia $multimedia;

    /**
     * @var MultimediaStatusEnum
     */
    public readonly MultimediaStatusEnum $onStatus;

    /**
     * @param Multimedia           $multimedia
     * @param MultimediaStatusEnum $onStatus
     */
    public function __construct(Multimedia $multimedia, MultimediaStatusEnum $onStatus)
    {
        $this->multimedia = $multimedia;
        $this->onStatus = $onStatus;
    }
}