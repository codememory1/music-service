<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Between extends Constraint
{
    public readonly string $with;
    public readonly bool $property;
    public readonly string $message;

    public function __construct(
        string $with,
        bool $property = true,
        ?string $message = null,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);

        $this->with = $with;
        $this->property = $property;
        $this->message = $message ?? 'The {{ current }} property does not match the {{ with }} property';
        $this->payload = $payload;
    }
}