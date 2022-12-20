<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_CLASS)]
final class Collection extends Constraint
{
    public function __construct(
        public readonly string $methodName,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);
    }

    public function getTargets(): array|string
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}