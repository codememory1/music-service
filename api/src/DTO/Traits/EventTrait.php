<?php

namespace App\DTO\Traits;

use App\Enum\Interfaces\EventInterface;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Trait EventTrait.
 *
 * @package App\DTO\Traits
 *
 * @author  Codememory
 */
trait EventTrait
{
    #[Assert\NotBlank(message: 'event@keyIsRequired')]
    public ?EventInterface $key = null;
    public array $payload = [];

    #[Assert\Callback]
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