<?php

namespace App\Rest\Validator;

use App\Enum\WebSocketClientMessageTypeEnum;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\ConstraintViolationInterface;

class WebSocketConstraintInfo
{
    private ConstraintViolationInterface $constraintViolation;

    public function __construct(ConstraintViolationInterface $constraintViolation)
    {
        $this->constraintViolation = $constraintViolation;
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