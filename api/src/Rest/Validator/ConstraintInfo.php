<?php

namespace App\Rest\Validator;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Class ConstraintInfo.
 *
 * @package App\Rest\Validator
 *
 * @author  Codememory
 */
class ConstraintInfo
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
    public function getType(): ?ResponseTypeEnum
    {
        return $this->getPayload()[0] ?? null;
    }

    #[Pure]
    public function getStatusCode(): ?int
    {
        return $this->getPayload()[1] ?? null;
    }
}