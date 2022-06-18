<?php

namespace App\Message;

/**
 * Class MultimediaMetadataMessage.
 *
 * @package App\Message
 *
 * @author  Codememory
 */
class MultimediaMetadataMessage
{
    /**
     * @var int
     */
    public readonly int $multimediaId;

    /**
     * @param int $multimediaId
     */
    public function __construct(int $multimediaId)
    {
        $this->multimediaId = $multimediaId;
    }
}