<?php

namespace App\Dto\Transfer\Traits;

use App\Dto\Constraints as DtoConstraints;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

trait EventPayloadTrait
{
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new AppAssert\Callback('callbackPayload')
    ])]
    public array $payload = [];

    public function callbackPayload(ExecutionContextInterface $context): void
    {
        if (null !== $this->key) {
            $context
                ->getValidator()
                ->inContext($context)
                ->atPath('payload')
                ->validate($this->payload, new AppAssert\JsonSchema($this->key->value, 'event@invalidPayload'));
        }
    }
}