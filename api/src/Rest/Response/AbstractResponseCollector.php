<?php

namespace App\Rest\Response;

use App\Enum\PlatformCodeEnum;
use App\Rest\Response\Interfaces\ResponseCollectorInterface;
use LogicException;

abstract class AbstractResponseCollector implements ResponseCollectorInterface
{
    private ?PlatformCodeEnum $platformCode = null;

    public function getPlatformCode(): PlatformCodeEnum
    {
        if (null === $this->platformCode) {
            throw new LogicException(sprintf('No framework code specified for response scheme %s', static::class));
        }

        return $this->platformCode;
    }

    public function setPlatformCode(PlatformCodeEnum $platformCode): static
    {
        $this->platformCode = $platformCode;

        return $this;
    }
}