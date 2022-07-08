<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints\Composite;

/**
 * Class Condition.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Condition extends Composite
{
    public string $callbackCondition;
    public array $constraints;

    public function __construct(string $callbackCondition, array $constraints, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        $this->callbackCondition = $callbackCondition;
        $this->constraints = $constraints;

        parent::__construct($options, $groups, $payload);
    }

    /**
     * @inheritDoc
     */
    protected function getCompositeOption(): string
    {
        return 'constraints';
    }
}