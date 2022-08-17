<?php

namespace App\ResponseData\Traits;

use DateTimeImmutable;

trait DateTimeHandlerTrait
{
    public function handleDateTime(?DateTimeImmutable $dateTimeImmutable): ?string
    {
        return $dateTimeImmutable?->format('Y-m-d H:i:s');
    }
}