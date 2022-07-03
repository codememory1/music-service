<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class Between.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Between extends Constraint
{
    public string $with;
    public bool $property;
    public string $message = 'The {{ current }} property does not match the {{ with }} property';

    public function __construct(string $with, bool $property = true, ?string $message = null, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->with = $with;
        $this->property = $property;
        $this->message = $message;
        $this->payload = $payload;
    }
}