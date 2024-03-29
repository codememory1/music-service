<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Exist extends Constraint
{
    public function __construct(
        public readonly string $entity,
        public readonly string $property,
        public readonly string $message = 'No entry found in table {{ table }} with {{ property }} {{ value }}',
        public readonly bool $allowedNull = false,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);
    }
}