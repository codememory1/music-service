<?php

namespace App\Rest\Validator;

use App\DTO\Interfaces\DTOInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Enum\ResponseTypeEnum;
use App\Rest\Http\Response;
use App\Rest\Http\ResponseSchema;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationInterface;
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
    private ValidatorInterface $validator;
    private ?ConstraintViolationListInterface $constraintViolation = null;
    private ResponseSchema $responseSchema;
    private Response $response;

    public function __construct(
        ValidatorInterface $validator,
        ResponseSchema $responseSchema,
        Response $response,
    ) {
        $this->validator = $validator;
        $this->responseSchema = $responseSchema;
        $this->response = $response;
    }

    public function validate(DTOInterface|EntityInterface $object, array $groups = []): bool
    {
        $this->constraintViolation = $this->validator->validate($object, groups: $groups);

        return count($this->constraintViolation) <= 0;
    }

    public function getResponse(): JsonResponse
    {
        $messages = [];
        $this->responseSchema
            ->setType(ResponseTypeEnum::INPUT_VALIDATION)
            ->setStatusCode(422);

        /** @var ConstraintViolationInterface $value */
        foreach ($this->constraintViolation as $value) {
            $constraintInto = new ConstraintInfo($value);

            $messages[$value->getPropertyPath()] = $constraintInto->getMessage();

            if ([] !== $constraintInto->getPayload()) {
                $this->responseSchema->setType($constraintInto->getType());
                $this->responseSchema->setStatusCode($constraintInto->getStatusCode());
            }
        }

        $this->responseSchema->setMessage($messages);

        return $this->response->getResponse($this->responseSchema);
    }
}