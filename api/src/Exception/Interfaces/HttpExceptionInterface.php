<?php

namespace App\Exception\Interfaces;

use App\Enum\PlatformCodeEnum;

interface HttpExceptionInterface
{
    public function getHttpCode(): int;

    public function getPlatformCode(): PlatformCodeEnum;

    public function getMessage(): string;

    public function getParameters(): array;

    public function getHeaders(): array;
}