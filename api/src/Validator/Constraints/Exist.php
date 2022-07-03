<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class Exist.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Exist extends Constraint
{
    public string $entity;
    public string $property;
    public ?string $message = 'No entry found in table {{ table }} with {{ property }} {{ value }}';
    public bool $allowedNull;

    public function __construct(string $entity, string $property, ?string $message = null, bool $allowedNull = false, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->entity = $entity;
        $this->property = $property;
        $this->message = $message;
        $this->allowedNull = $allowedNull;
    }
}