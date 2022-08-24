<?php

namespace App\Rest\Validator;

use App\Dto\Interfaces\DataTransferInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Validator\Interfaces\ValidatorInterface;
use function call_user_func;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidatorInterface;

abstract class AbstractValidator implements ValidatorInterface
{
    private SymfonyValidatorInterface $validator;
    private ?ConstraintViolationListInterface $constraintViolation = null;

    public function __construct(SymfonyValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    protected function constraintViolation(?callable $handleConstraintInfo = null): void
    {
        /** @var ConstraintViolationInterface $value */
        foreach ($this->constraintViolation as $value) {
            if (null !== $handleConstraintInfo) {
                call_user_func($handleConstraintInfo, $value);
            }
        }
    }

    public function validate(DataTransferInterface|EntityInterface $object, ?callable $customResponse = null, array $groups = []): void
    {
        $this->constraintViolation = $this->validator->validate($object, groups: $groups);

        $this->constraintViolation($customResponse);
    }
}