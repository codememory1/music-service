<?php

namespace App\ValidatorConstraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class Exist
 *
 * @package App\ValidatorConstraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Exist extends Constraint
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
     * @var string|null
     */
    public ?string $message = 'No entry found in table {{ table }} with {{ property }} {{ value }}';

    /**
     * @param string      $entity
     * @param string      $property
     * @param string|null $message
     * @param mixed|null  $payload
     */
    public function __construct(string $entity, string $property, string $message = null, mixed $payload = null)
    {

        parent::__construct(payload: $payload);

        $this->entity = $entity;
        $this->property = $property;
        $this->message = $message;

    }

}