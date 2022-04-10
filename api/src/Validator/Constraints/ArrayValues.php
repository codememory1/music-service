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
    public ?string $minMessage = 'The {{ property }} property must contain at least {{ min }} values';

    /**
     * @var null|string
     */
    public ?string $maxMessage = 'The {{ property }} property must contain a maximum of {{ max }} values';

    /**
     * @param int         $min
     * @param null|int    $max
     * @param null|string $minMessage
     * @param null|string $maxMessage
     * @param null|mixed  $options
     * @param null|array  $groups
     * @param null|mixed  $payload
     */
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
        $this->minMessage = $minMessage ?? $this->minMessage;
        $this->maxMessage = $maxMessage ?? $this->maxMessage;
    }
}