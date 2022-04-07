<?php

namespace App\Traits\Entity;

/**
 * Trait TimestampTrait.
 *
 * @package App\Traits\Entity
 *
 * @author  Codememory
 */
trait TimestampTrait
{
    use CreatedAtTrait;

    use UpdatedAtTrait;
}