<?php

namespace App\Rest\Validator;

use App\Interfaces\DTOInterface;
use App\Interfaces\EntityInterface;
use App\Rest\Http\Response;
use App\Rest\Http\ResponseCollection;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Validator.
 *
 * @package App\Rest\Validator
 *
 * @author  Codememory
 */
class Validator
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var ResponseCollection
     */
    private ResponseCollection $responseCollection;

    /**
     * @var null|ConstraintViolationListInterface
     */
    private ?ConstraintViolationListInterface $errors = null;

    /**
     * @var bool
     */
    private bool $isValidate = false;

    /**
     * @param ValidatorInterface $validator
     * @param ResponseCollection $responseCollection
     */
    #[Pure]
    public function __construct(ValidatorInterface $validator, ResponseCollection $responseCollection)
    {
        $this->validator = $validator;
        $this->responseCollection = $responseCollection;
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return $this->validator;
    }

    /**
     * @param DTOInterface|EntityInterface $entityOrDTO
     *
     * @return $this
     */
    public function validate(EntityInterface|DTOInterface $entityOrDTO): self
    {
        $this->errors = $this->validator->validate($entityOrDTO);

        if (count($this->errors) > 0) {
            $this->validationFailed($this->getInfo());

            $this->isValidate = false;
        } else {
            $this->isValidate = true;
        }

        return $this;
    }

    /**
     * @return ValidateInfo
     */
    public function getInfo(): ValidateInfo
    {
        return new ValidateInfo($this->errors);
    }

    /**
     * @return bool
     */
    public function isValidate(): bool
    {
        return $this->isValidate;
    }

    /**
     * @param int $code
     *
     * @return Response
     */
    public function getResponse(int $code = 400): Response
    {
        return $this->responseCollection->getResponse(code: $code);
    }

    /**
     * @param ValidateInfo $info
     *
     * @return void
     */
    private function validationFailed(ValidateInfo $info): void
    {
        $type = $info->getType();
        $message = $info->getMessage();

        if (null === $type) {
            $this->responseCollection->errorInputValidation($message);
        } else {
            $this->responseCollection->customErrorType($type, $message);
        }
    }
}