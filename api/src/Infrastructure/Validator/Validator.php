<?php

namespace App\Infrastructure\Validator;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use App\Exception\WebSocketException;
use function call_user_func;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidatorInterface;

final class Validator
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
            $platformCode = $constraintViolationInfo->getPlatformCode() ?: PlatformCodeEnum::INPUT_ERROR;

            $this->cli($constraintViolationInfo, $platformCode, $throw);

            if (null === $throw) {
                throw new WebSocketException($platformCode, $constraintViolationInfo->getMessage());
            }

            call_user_func($throw, $constraintViolationInfo);
        }
    }

    public function getConstraintViolationList(): ?ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }

    private function cli(ConstraintInfo $constraintViolationInfo, PlatformCodeEnum $platformCode, ?callable $throw = null): void
    {
        if ('cli' !== PHP_SAPI) {
            if (null === $throw) {
                throw new HttpException($constraintViolationInfo->getHttpCode() ?: 400, $platformCode, $constraintViolationInfo->getMessage());
            }

            call_user_func($throw, $constraintViolationInfo);
        }
    }
}