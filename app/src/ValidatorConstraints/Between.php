<?php

namespace App\ValidatorConstraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class Between
 *
 * @package App\ValidatorConstraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Between extends Constraint
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
     * @param mixed|null  $payload
     */
    public function __construct(string $withGetter, string $message = null, mixed $payload = null)
    {

        parent::__construct(payload: $payload);

        $this->with = $withGetter;
        $this->message = $message;
        $this->payload = $payload;

    }

}