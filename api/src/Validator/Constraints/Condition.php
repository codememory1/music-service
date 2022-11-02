<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints\Composite;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Condition extends Composite
{
    public function __construct(
        public readonly string $callbackCondition,
        public readonly array $constraints,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
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