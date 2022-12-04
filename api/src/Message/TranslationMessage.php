<?php

namespace App\Message;

final class TranslationMessage
{
    public function __construct(
        public readonly string $text,
        public readonly string $uuid
    ) {
    }
}