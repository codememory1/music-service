<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class JsonSchema extends Constraint
{
    public function __construct(
        public readonly string $schemaName,
        public readonly string $message = 'The value of the {{ property }} property does not match the schema',
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);
    }
}