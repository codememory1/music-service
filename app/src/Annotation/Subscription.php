<?php

namespace App\Annotation;

use Attribute;

/**
 * Class Subscription.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_METHOD)]
class Subscription
{
    /**
     * @var string
     */
    public readonly string $key;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }
}