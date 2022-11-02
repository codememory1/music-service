<?php

namespace App\Validator\Constraints;

use Attribute;
use LogicException;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class MinMaxBetweenProperty extends Constraint
{
    public readonly ?string $message;

    public function __construct(
        public readonly string $property,
        public readonly bool $min = false,
        public readonly bool $max = false,
        ?string $message = null,
        public readonly bool $allowedNull = false,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);

        if (false === $this->min && false === $this->max || (false !== $this->min && false !== $this->max)) {
            throw new LogicException('One of the value min, max must be filled');
        }

        if (false !== $this->min) {
            $this->message = $message ?? 'The {{ currentProperty }} property cannot exceed the value of the {{ withProperty }} property';
        }

        if (false !== $this->max) {
            $this->message = $message ?? 'The {{ currentProperty }} property cannot be less than the {{ withProperty }} property';
        }
    }
}