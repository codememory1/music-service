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
    public string $delimiter;
    public int $min;
    public ?int $max;
    public ?string $minMessage = 'The number of values for {{ property }} property must be at least {{ min }}';
    public ?string $maxMessage = 'The number of values for the {{ property }} property must be no more than {{ max }}';

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