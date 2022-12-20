<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
class QuantityByDelimiter extends Constraint
{
    public function __construct(
        public readonly string $delimiter,
        public readonly int $min = 0,
        public readonly ?int $max = null,
        public readonly string $minMessage = 'The number of values for {{ property }} property must be at least {{ min }}',
        public readonly string $maxMessage = 'The number of values for the {{ property }} property must be no more than {{ max }}',
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);
    }
}