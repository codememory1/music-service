<?php

namespace App\Infrastructure\Validator;

use App\Enum\PlatformCodeEnum;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ConstraintInfo
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
    public function getHttpCode(): ?int
    {
        return $this->getPayload()[Validator::PHD] ?? null;
    }

    #[Pure]
    public function getPlatformCode(): ?PlatformCodeEnum
    {
        return $this->getPayload()[Validator::PPC] ?? null;
    }
}