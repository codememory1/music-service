<?php

namespace App\ResponseData\Traits;

use DateTimeImmutable;

/**
 * Trait DateTimeHandlerTrait.
 *
 * @package App\ResponseData\Traits
 *
 * @author  Codememory
 */
trait DateTimeHandlerTrait
{
    public function handleDateTime(?DateTimeImmutable $dateTimeImmutable): ?string
    {
        return $dateTimeImmutable?->format('Y-m-d H:i:s');
    }
}