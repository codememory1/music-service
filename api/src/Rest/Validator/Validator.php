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
    /**
     * @var GroupExpressionLanguage
     */
    public readonly GroupExpressionLanguage $groupExprLanguage;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var null|ConstraintViolationListInterface
     */
    private ?ConstraintViolationListInterface $constraintViolation = null;

    /**
     * @var ResponseSchema
     */
    private ResponseSchema $responseSchema;

    /**
     * @var Response
     */
    private Response $response;

    /**
     * @param ValidatorInterface      $validator
     * @param GroupExpressionLanguage $groupExpressionLanguage
     * @param ResponseSchema          $responseSchema
     * @param Response                $response
     */
    public function __construct(
        ValidatorInterface $validator,
        GroupExpressionLanguage $groupExpressionLanguage,
        ResponseSchema $responseSchema,
        Response $response
    )
    {
        $this->validator = $validator;
        $this->groupExprLanguage = $groupExpressionLanguage;
        $this->responseSchema = $responseSchema;
        $this->response = $response;
    }

    /**
     * @param DTOInterface|EntityInterface $object
     *
     * @return bool
     */
    public function validate(DTOInterface|EntityInterface $object): bool
    {
        $this->constraintViolation = $this->validator->validate($object, groups: $this->groupExprLanguage->getGroups());

        return count($this->constraintViolation) <= 0;
    }

    /**
     * @return JsonResponse
     */
    public function getResponse(): JsonResponse
    {
        $messages = [];
        $this->responseSchema
            ->setType(ResponseTypeEnum::INPUT_VALIDATION)
            ->setStatusCode(422);

        /** @var ConstraintViolationInterface $value */
        foreach ($this->constraintViolation as $value) {
            $messages[$value->getPropertyPath()] = $value->getMessage();

            if (null !== $value->getConstraint()->payload) {
                $this->responseSchema->setType($value->getConstraint()->payload);
            }
        }

        $this->responseSchema->setMessage($messages);

        return $this->response->getResponse($this->responseSchema);
    }
}