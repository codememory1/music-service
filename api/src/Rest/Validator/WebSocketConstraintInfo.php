<?php

namespace App\Rest\Validator;

use App\Enum\WebSocketClientMessageTypeEnum;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\ConstraintViolationInterface;

class WebSocketConstraintInfo
{
    public function __construct(
        private readonly ConstraintViolationInterface $constraintViolation
    ) {
    }

    public function getMessage(): ?string
    {
        return $this->constraintViolation->getMessage();
    }

    #[Pure]
    public function getPayload(): array
    {
        return $this->constraintViolation->getConstraint()->payload ?: [];
    }

    #[Pure]
    public function getType(): ?WebSocketClientMessageTypeEnum
    {
        return $this->getPayload()[0] ?? null;
    }
}