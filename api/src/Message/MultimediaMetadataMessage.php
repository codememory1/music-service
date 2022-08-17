<?php

namespace App\Message;

final class MultimediaMetadataMessage
{
    public readonly int $multimediaId;

    public function __construct(int $multimediaId)
    {
        $this->multimediaId = $multimediaId;
    }
}