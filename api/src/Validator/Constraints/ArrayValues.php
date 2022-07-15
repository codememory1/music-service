<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class ArrayValues.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayValues extends Constraint
{
    public readonly int $min;
    public readonly ?int $max;
    public readonly ?string $minMessage;
    public readonly ?string $maxMessage;

    public function __construct(
        int $min = 0,
        ?int $max = null,
        ?string $minMessage = null,
        ?string $maxMessage = null,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);

        $this->min = $min;
        $this->max = $max;
        $this->minMessage = $minMessage ?? 'The {{ property }} property must contain at least {{ min }} values';
        $this->maxMessage = $maxMessage ?? 'The {{ property }} property must contain a maximum of {{ max }} values';
    }
}