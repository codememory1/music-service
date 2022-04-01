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
	 * @var bool
	 */
	public bool $property;

    /**
     * @var string
     */
    public string $message = 'The {{ current }} property does not match the {{ with }} property';

	/**
	 * @param string      $with
	 * @param bool        $property
	 * @param string|null $message
	 * @param mixed|null  $options
	 * @param array|null  $groups
	 * @param mixed|null  $payload
	 */
    public function __construct(string $with, bool $property = true, string $message = null, mixed $options = null, array $groups = null, mixed $payload = null)
    {

        parent::__construct($options, $groups, $payload);

        $this->with = $with;
		$this->property = $property;
        $this->message = $message;
        $this->payload = $payload;

    }

}