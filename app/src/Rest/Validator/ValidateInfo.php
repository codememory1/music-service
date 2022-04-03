<?php

namespace App\Rest\Validator;

use App\Enum\ApiResponseTypeEnum;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ValidateInfo.
 *
 * @package App\Rest\Validator
 *
 * @author  Codememory
 */
class ValidateInfo
{
    /**
     * @var ConstraintViolation
     */
    private ConstraintViolation $constraintViolation;

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     */
    public function __construct(ConstraintViolationListInterface $constraintViolationList)
    {
        $this->constraintViolation = $constraintViolationList->get(0);
    }

    /**
     * @return null|ApiResponseTypeEnum
     */
    #[Pure]
    public function getType(): ?ApiResponseTypeEnum
    {
        return $this->constraintViolation->getConstraint()->payload;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->constraintViolation->getMessage();
    }
}