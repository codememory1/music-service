<?php

namespace App\Rest\Validator;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Class ConstraintInfo
 *
 * @package App\Rest\Validator
 *
 * @author  Codememory
 */
class ConstraintInfo
{
    /**
     * @var ConstraintViolationInterface
     */
    private ConstraintViolationInterface $constraintViolation;

    /**
     * @param ConstraintViolationInterface $constraintViolation
     */
    public function __construct(ConstraintViolationInterface $constraintViolation)
    {
        $this->constraintViolation = $constraintViolation;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->constraintViolation->getMessage();
    }

    /**
     * @return array
     */
    #[Pure]
    public function getPayload(): array
    {
        return $this->constraintViolation->getConstraint()->payload ?: [];
    }

    /**
     * @return ResponseTypeEnum|null
     */
    #[Pure]
    public function getType(): ?ResponseTypeEnum
    {
        return $this->getPayload()[0] ?? null;
    }

    /**
     * @return int|null
     */
    #[Pure]
    public function getStatusCode(): ?int
    {
        return $this->getPayload()[1] ?? null;
    }
}