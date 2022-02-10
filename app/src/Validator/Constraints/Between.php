<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class Between
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Between extends Constraint
{

    /**
     * @var string
     */
    public string $with;

    /**
     * @var string
     */
    public string $message = 'The {{ current }} property does not match the {{ with }} property';

    /**
     * @param string      $withGetter
     * @param string|null $message
     * @param mixed|null  $options
     * @param array|null  $groups
     * @param mixed|null  $payload
     */
    public function __construct(string $withGetter, string $message = null, mixed $options = null, array $groups = null, mixed $payload = null)
    {

        parent::__construct($options, $groups, $payload);

        $this->with = $withGetter;
        $this->message = $message;
        $this->payload = $payload;

    }

}