<?php

namespace App\Message;

final class MultimediaMetadataMessage
{
    public function __construct(
        public readonly int $multimediaId
    ) {}
}