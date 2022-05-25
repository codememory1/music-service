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
    /**
     * @param null|DateTimeImmutable $dateTimeImmutable
     *
     * @return null|string
     */
    public function handleDateTime(?DateTimeImmutable $dateTimeImmutable): ?string
    {
        return $dateTimeImmutable?->format('Y-m-d H:i:s');
    }
}