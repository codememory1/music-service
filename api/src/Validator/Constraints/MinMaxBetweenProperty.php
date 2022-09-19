<?php

namespace App\Validator\Constraints;

use Attribute;
use LogicException;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class MinMaxBetweenProperty extends Constraint
{
    public readonly string $property;
    public readonly bool $min;
    public readonly bool $max;
    public readonly ?string $message;
    public readonly bool $allowedNull;

    public function __construct(
        string $property,
        bool $min = false,
        bool $max = false,
        ?string $message = null,
        bool $allowedNull = false,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);

        if (false === $min && false === $max || (false !== $min && false !== $max)) {
            throw new LogicException('One of the value min, max must be filled');
        }

        $this->property = $property;
        $this->min = $min;
        $this->max = $max;

        if (false !== $min) {
            $this->message = $message ?? 'The {{ currentProperty }} property cannot exceed the value of the {{ withProperty }} property';
        }

        if (false !== $max) {
            $this->message = $message ?? 'The {{ currentProperty }} property cannot be less than the {{ withProperty }} property';
        }

        $this->allowedNull = $allowedNull;
    }
}