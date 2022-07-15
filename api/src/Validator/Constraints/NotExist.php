<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class NotExist.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class NotExist extends Constraint
{
    public readonly string $entity;
    public readonly string $property;
    public readonly ?string $message;
    public readonly bool $allowedNull;

    public function __construct(
        string $entity,
        string $property,
        ?string $message = null,
        bool $allowedNull = false,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);

        $this->entity = $entity;
        $this->property = $property;
        $this->message = $message ?? 'No entry not found in table {{ table }} with {{ property }} {{ value }}';
        $this->allowedNull = $allowedNull;
    }
}