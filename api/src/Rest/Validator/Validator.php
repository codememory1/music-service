<?php

namespace App\Rest\Validator;

use App\Dto\Interfaces\DataTransferInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Enum\ResponseTypeEnum;
use App\Rest\Http\Exceptions\ApiResponseException;
use function call_user_func;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    private ValidatorInterface $validator;
    private ?ConstraintViolationListInterface $constraintViolation = null;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(DataTransferInterface|EntityInterface $object, ?callable $customResponse = null, array $groups = []): void
    {
        $this->constraintViolation = $this->validator->validate($object, groups: $groups);

        $this->getResponse($customResponse);
    }

    private function getResponse(?callable $customResponse = null): void
    {
        /** @var ConstraintViolationInterface $value */
        foreach ($this->constraintViolation as $value) {
            $constraintInto = new ConstraintInfo($value);

            if (null !== $customResponse) {
                call_user_func($customResponse);
            } else {
                if ([] !== $constraintInto->getPayload()) {
                    throw new ApiResponseException($constraintInto->getStatusCode(), $constraintInto->getType(), $constraintInto->getMessage());
                }

                throw new ApiResponseException(422, ResponseTypeEnum::INPUT_VALIDATION, $constraintInto->getMessage());
            }
        }
    }
}