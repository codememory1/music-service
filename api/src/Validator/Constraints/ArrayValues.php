<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ArrayValues extends Constraint
{
    public function __construct(
        public readonly int $min = 0,
        public readonly ?int $max = null,
        public readonly string $minMessage = 'The {{ property }} property must contain at least {{ min }} values',
        public readonly string $maxMessage = 'The {{ property }} property must contain a maximum of {{ max }} values',
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);
    }
}