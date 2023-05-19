<?php

namespace App\Constraints\Assert;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ComparisonBetween extends Constraint
{
    public readonly bool $is;
    public readonly string $withProperty;
    public readonly string $message;

    public function __construct(bool $is, string $withProperty, string $message, mixed $options = null, array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->is = $is;
        $this->withProperty = $withProperty;
        $this->message = $message;
    }
}