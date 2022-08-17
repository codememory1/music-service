<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class JsonSchema extends Constraint
{
    public readonly string $schemaName;
    public readonly string $message;

    public function __construct(
        string $schemaName,
        ?string $message = null,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);

        $this->schemaName = $schemaName;
        $this->message = $message ?: 'The value of the {{ property }} property does not match the schema';
    }
}