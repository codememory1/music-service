<?php

namespace App\Rest\Http;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\ResponseCollectionInterface;
use App\Rest\Translator;

/**
 * Class ResponseCollection.
 *
 * @package App\Rest\Http
 *
 * @author  Codememory
 */
class ResponseCollection implements ResponseCollectionInterface
{
    /**
     * @var ApiResponseSchema
     */
    private ApiResponseSchema $apiResponseSchema;

    /**
     * @var Translator
     */
    private Translator $translator;

    /**
     * @var string
     */
    private string $status = 'error';

    /**
     * @var int
     */
    private int $code = 400;

    /**
     * @param ApiResponseSchema $apiResponseSchema
     * @param Translator        $translator
     */
    public function __construct(ApiResponseSchema $apiResponseSchema, Translator $translator)
    {
        $this->apiResponseSchema = $apiResponseSchema;
        $this->translator = $translator;
    }

    /**
     * @param string $translationKey
     *
     * @return $this
     */
    final public function successCreate(string $translationKey): self
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::CREATE,
            $translationKey,
            'success',
            201
        );
    }

    /**
     * @param string $translationKey
     *
     * @return $this
     */
    final public function successUpdate(string $translationKey): self
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::UPDATE,
            $translationKey,
            'success',
            200
        );
    }

    /**
     * @param string $translationKey
     *
     * @return $this
     */
    final public function successDelete(string $translationKey): self
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::DELETE,
            $translationKey,
            'success',
            200
        );
    }

    /**
     * @param string $translationKey
     *
     * @return $this
     */
    final public function exist(string $translationKey): self
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::CHECK_EXIST,
            $translationKey,
            'error',
            400
        );
    }

    /**
     * @param string $translationKey
     *
     * @return $this
     */
    final public function notExist(string $translationKey): self
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::CHECK_EXIST,
            $translationKey,
            'error',
            404
        );
    }

    /**
     * @param string $translationKey
     *
     * @return $this
     */
    final public function successAuth(): self
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::AUTH,
            'common@successAuth',
            'success',
            200
        );
    }

    /**
     * @return $this
     */
    final public function successRegister(): self
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::REGISTRATION,
            'common@successRegister',
            'success',
            200
        );
    }

    /**
     * @param string $translationKey
     *
     * @return $this
     */
    final public function errorInputValidation(string $translationKey): self
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::INPUT_VALIDATION,
            $translationKey,
            'error',
            400
        );
    }

    /**
     * @param null|string $translationKey
     *
     * @return $this
     */
    final public function accessIsDenied(?string $translationKey = null): self
    {
        $translationKey ??= 'common@accessIsDenied';

        return $this->prepareResponse(
            ApiResponseTypeEnum::ACCESS_IS_DENIED,
            $translationKey,
            'error',
            403
        );
    }

    /**
     * @return $this
     */
    final public function notAuth(): self
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::CHECK_AUTH,
            'common@notAuth',
            'error',
            401
        );
    }

    /**
     * @return $this
     */
    final public function notValid(): self
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::CHECK_VALID,
            'common@notValid',
            'error',
            422
        );
    }

    /**
     * @param string $translationKey
     *
     * @return $this
     */
    final public function successActivation(string $translationKey): self
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::ACTIVATION,
            $translationKey,
            'success',
            200
        );
    }

    /**
     * @inheritDoc
     */
    public function getResponse(?string $status = null, ?int $code = null): Response
    {
        $status ??= $this->status;
        $code ??= $this->code;

        return new Response($this->apiResponseSchema, $status, $code);
    }

    /**
     * @param ApiResponseTypeEnum $apiResponseTypeEnum
     * @param string              $translationKey
     * @param string              $status
     * @param int                 $code
     *
     * @return $this
     */
    private function prepareResponse(ApiResponseTypeEnum $apiResponseTypeEnum, string $translationKey, string $status, int $code): self
    {
        $this->apiResponseSchema->setMessage(
            $apiResponseTypeEnum,
            $this->translator->getTranslation($translationKey)
        );

        $this->status = $status;
        $this->code = $code;

        return $this;
    }
}