<?php

namespace App\Rest\Response\Interfaces;

use App\Enum\PlatformCodeEnum;

interface HttpSchemeInterface extends SchemePrototypeInterface
{
    public function getHttpCode(): int;

    public function getPlatformCode(): PlatformCodeEnum;
}