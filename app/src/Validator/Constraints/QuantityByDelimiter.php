<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class QuantityByDelimiter.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class QuantityByDelimiter extends Constraint
{
    /**
     * @var string
     */
    public string $delimiter;

    /**
     * @var int
     */
    public int $min;

    /**
     * @var null|int
     */
    public ?int $max;

    /**
     * @var null|string
     */
    public ?string $minMessage = 'The number of values for {{ property }} property must be at least {{ min }}';

    /**
     * @var null|string
     */
    public ?string $maxMessage = 'The number of values for the {{ property }} property must be no more than {{ max }}';

    /**
     * @param string      $delimiter
     * @param int         $min
     * @param null|int    $max
     * @param null|string $minMessage
     * @param null|string $maxMessage
     * @param null|mixed  $options
     * @param null|array  $groups
     * @param null|mixed  $payload
     */
    public function __construct(string $delimiter, int $min = 0, ?int $max = null, ?string $minMessage = null, ?string $maxMessage = null, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->delimiter = $delimiter;
        $this->min = $min;
        $this->max = $max;
        $this->minMessage = $minMessage ?? $this->minMessage;
        $this->maxMessage = $maxMessage ?? $this->maxMessage;
    }
}