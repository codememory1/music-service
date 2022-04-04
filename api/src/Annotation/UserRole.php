<?php

namespace App\Annotation;

use Attribute;
use function is_string;

/**
 * Class UserRole.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_METHOD)]
class UserRole
{
    public readonly array $keys;

    /**
     * @param array|string $keys
     */
    public function __construct(array|string $keys)
    {
        $this->keys = is_string($keys) ? [$keys] : $keys;
    }
}