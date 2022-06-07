<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class JsonSchema.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class JsonSchema extends Constraint
{
    /**
     * @var string
     */
    public readonly string $schemaName;

    /**
     * @var string
     */
    public readonly string $message;

    /**
     * @param string      $schemaName
     * @param null|string $message
     * @param null|mixed  $options
     * @param null|array  $groups
     * @param null|mixed  $payload
     */
    public function __construct(string $schemaName, ?string $message = null, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->schemaName = $schemaName;
        $this->message = $message ?: 'The value of the {{ property }} property does not match the schema';
    }
}