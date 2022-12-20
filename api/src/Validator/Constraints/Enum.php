<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Enum extends Constraint
{
    public function __construct(
        public readonly string $enum,
        public readonly bool $allowedNullable = false,
        public readonly string $message = 'The {{ case }} case does not exist in the {{ enum }} enum',
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);
    }
}