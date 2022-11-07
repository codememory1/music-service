<?php

namespace App\Exception\Interfaces;

use App\Enum\PlatformCodeEnum;

interface WebSocketExceptionInterface
{
    public function getPlatformCode(): PlatformCodeEnum;

    public function getMessage(): string;

    public function getParameters(): array;
}