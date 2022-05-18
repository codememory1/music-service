<?php

namespace App\Rest\Validator;

use App\DTO\Interfaces\DTOInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Enum\ResponseTypeEnum;
use App\Rest\Http\Request;
use App\Rest\Http\Response;
use App\Rest\Http\ResponseSchema;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
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
     * @var ParameterBag|ParameterBagInterface
     */
    private ParameterBagInterface|ParameterBag $parameterBag;

    /**
     * @param ValidatorInterface      $validator
     * @param GroupExpressionLanguage $groupExpressionLanguage
     * @param ResponseSchema          $responseSchema
     * @param Response                $response
     * @param ParameterBagInterface   $parameterBag
     */
    public function __construct(
        ValidatorInterface $validator,
        GroupExpressionLanguage $groupExpressionLanguage,
        ResponseSchema $responseSchema,
        Request $request,
        Response $response,
    ) {
        $this->validator = $validator;
        $this->groupExprLanguage = $groupExpressionLanguage;
        $this->responseSchema = $responseSchema;
        $this->response = $response;
        $this->parameterBag = $request->request->attributes;
    }

    /**
     * @return $this
     */
    public function byRolePermission(): self
    {
        $this->groupExprLanguage
            ->createGroup()
            ->addExpr('request_type', $this->parameterBag->get('request_type'))
            ->addExpr('role_permission', 'user_role_permission');

        return $this;
    }

    /**
     * @return $this
     */
    public function bySubscriptionPermission(): self
    {
        $this->groupExprLanguage
            ->createGroup()
            ->addExpr('request_type', $this->parameterBag->get('request_type'))
            ->addExpr('subscription_permission', 'subscription_permission');

        return $this;
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