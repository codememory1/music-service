<?php

namespace App\Rest\Response\Interfaces;

use App\Enum\PlatformCodeEnum;

interface ResponseCollectorInterface
{
    public function getPlatformCode(): PlatformCodeEnum;

    public function setPlatformCode(PlatformCodeEnum $platformCode): self;

    public function collect(): self;

    public function getCollectedResponse(): array;
}