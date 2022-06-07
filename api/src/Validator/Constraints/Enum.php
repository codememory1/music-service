<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class Enum.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Enum extends Constraint
{
    /**
     * @var string
     */
    public readonly string $enum;

    /**
     * @var bool
     */
    public readonly bool $allowedNullable;

    /**
     * @var null|string
     */
    public readonly ?string $message;

    /**
     * @param string      $enum
     * @param bool        $allowedNullable
     * @param null|string $message
     * @param null|mixed  $options
     * @param null|array  $groups
     * @param null|mixed  $payload
     */
    public function __construct(string $enum, bool $allowedNullable = false, ?string $message = null, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->enum = $enum;
        $this->allowedNullable = $allowedNullable;
        $this->message = $message ?: 'The {{ case }} case does not exist in the {{ enum }} enum';
    }
}