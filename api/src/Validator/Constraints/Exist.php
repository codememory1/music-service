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
    /**
     * @var string
     */
    public string $entity;

    /**
     * @var string
     */
    public string $property;

    /**
     * @var null|string
     */
    public ?string $message = 'No entry found in table {{ table }} with {{ property }} {{ value }}';
    public bool $allowedNull;

    /**
     * @param string      $entity
     * @param string      $property
     * @param null|string $message
     * @param bool        $allowedNull
     * @param null|mixed  $options
     * @param null|array  $groups
     * @param null|mixed  $payload
     */
    public function __construct(string $entity, string $property, ?string $message = null, bool $allowedNull = false, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->entity = $entity;
        $this->property = $property;
        $this->message = $message;
        $this->allowedNull = $allowedNull;
    }
}