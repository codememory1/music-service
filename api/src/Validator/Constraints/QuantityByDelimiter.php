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
    public readonly string $delimiter;
    public readonly int $min;
    public readonly ?int $max;
    public readonly ?string $minMessage;
    public readonly ?string $maxMessage;

    public function __construct(
        string $delimiter,
        int $min = 0,
        ?int $max = null,
        ?string $minMessage = null,
        ?string $maxMessage = null,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);

        $this->delimiter = $delimiter;
        $this->min = $min;
        $this->max = $max;
        $this->minMessage = $minMessage ?? 'The number of values for {{ property }} property must be at least {{ min }}';
        $this->maxMessage = $maxMessage ?? 'The number of values for the {{ property }} property must be no more than {{ max }}';
    }
}