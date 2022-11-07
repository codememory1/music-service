<?php

namespace App\Infrastructure\Validator;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidatorInterface;

class Validator
{
    public const PHD = 'http_code';
    public const PPC = 'platform_code';
    private ?ConstraintViolationListInterface $constraintViolationList = null;

    public function __construct(
        private readonly SymfonyValidatorInterface $validator
    ) {
    }

    /**
     * @param callable(Validator): never $throw
     */
    public function validate(object $object, ?callable $throw = null): void
    {
        $this->constraintViolationList = $this->validator->validate($object);

        foreach ($this->constraintViolationList as $constraintViolation) {
            $constraintViolationInfo = new ConstraintInfo($constraintViolation);
        }
    }

    public function getConstraintViolationList(): ?ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}