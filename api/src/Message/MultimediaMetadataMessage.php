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
    public readonly int $multimediaId;

    public function __construct(int $multimediaId)
    {
        $this->multimediaId = $multimediaId;
    }
}