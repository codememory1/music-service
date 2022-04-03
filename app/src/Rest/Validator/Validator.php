<?php

namespace App\Rest\Validator;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\DTOInterface;
use App\Interfaces\EntityInterface;
use App\Rest\Http\ApiResponseSchema;
use App\Rest\Http\Response;
use App\Rest\Translator;
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
     * @var Translator
     */
    private Translator $translator;

    /**
     * @var ApiResponseSchema
     */
    private ApiResponseSchema $apiResponseSchema;

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
     * @param Translator         $translator
     */
    #[Pure]
    public function __construct(ValidatorInterface $validator, Translator $translator)
    {
        $this->validator = $validator;
        $this->translator = $translator;
        $this->apiResponseSchema = new ApiResponseSchema();
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
            $info = $this->getInfo();

            $this->apiResponseSchema->setMessage(
                $info->getType() ?? ApiResponseTypeEnum::INPUT_VALIDATION,
                $this->translator->getTranslation($info->getMessage())
            );

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
        return new Response($this->apiResponseSchema, 'error', $code);
    }
}