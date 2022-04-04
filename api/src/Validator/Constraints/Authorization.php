<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class Authorization.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_CLASS)]
class Authorization extends Constraint
{
    /**
     * @var string
     */
    public string $message = 'Authorization is required to perform this action';

    /**
     * @param null|string $message
     * @param null|mixed  $options
     * @param null|array  $groups
     * @param null|mixed  $payload
     */
    public function __construct(?string $message = null, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getTargets(): array
    {
        return [self::CLASS_CONSTRAINT];
    }
}