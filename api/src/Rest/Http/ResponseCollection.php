<?php

namespace App\Rest\Http;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\ResponseCollectionInterface;
use App\Rest\Translator;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public readonly ApiResponseSchema $apiResponseSchema;

    /**
     * @var Translator
     */
    public readonly Translator $translator;

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
     * @return ResponseCollectionInterface
     */
    final public function successCreate(string $translationKey): ResponseCollectionInterface
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
     * @return ResponseCollectionInterface
     */
    final public function successUpdate(string $translationKey): ResponseCollectionInterface
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
     * @return ResponseCollectionInterface
     */
    final public function successDelete(string $translationKey): ResponseCollectionInterface
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
     * @return ResponseCollectionInterface
     */
    final public function exist(string $translationKey): ResponseCollectionInterface
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
     * @return ResponseCollectionInterface
     */
    final public function notExist(string $translationKey): ResponseCollectionInterface
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::CHECK_EXIST,
            $translationKey,
            'error',
            404
        );
    }

    /**
     * @param array $tokens
     *
     * @return ResponseCollectionInterface
     */
    final public function successAuth(array $tokens): ResponseCollectionInterface
    {
        $preparedResponse = $this->prepareResponse(
            ApiResponseTypeEnum::AUTH,
            'common@successAuth',
            'success',
            200
        );

        $this->apiResponseSchema->setData($tokens);

        return $preparedResponse;
    }

    /**
     * @return ResponseCollectionInterface
     */
    final public function successRegister(): ResponseCollectionInterface
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
     * @return ResponseCollectionInterface
     */
    final public function errorInputValidation(string $translationKey): ResponseCollectionInterface
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
     * @return ResponseCollectionInterface
     */
    final public function accessIsDenied(?string $translationKey = null): ResponseCollectionInterface
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
     * @return ResponseCollectionInterface
     */
    final public function notAuth(): ResponseCollectionInterface
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::CHECK_AUTH,
            'common@notAuth',
            'error',
            401
        );
    }

    /**
     * @param string $translationKey
     *
     * @return ResponseCollectionInterface
     */
    final public function notValid(string $translationKey): ResponseCollectionInterface
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::CHECK_VALID,
            $translationKey,
            'error',
            422
        );
    }

    /**
     * @param string $translationKey
     *
     * @return ResponseCollectionInterface
     */
    final public function successActivation(string $translationKey): ResponseCollectionInterface
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::ACTIVATION,
            $translationKey,
            'success',
            200
        );
    }

    /**
     * @param array $data
     *
     * @return ResponseCollectionInterface
     */
    final public function dataOutput(array $data): ResponseCollectionInterface
    {
        $preparedResponse = $this->prepareResponse(
            ApiResponseTypeEnum::DATA_OUTPUT,
            'common@dataOutput',
            'success',
            200
        );

        $this->apiResponseSchema->setData($data);

        return $preparedResponse;
    }

    /**
     * @param ApiResponseTypeEnum $type
     * @param string              $translationKey
     *
     * @return ResponseCollectionInterface
     */
    final public function customErrorType(ApiResponseTypeEnum $type, string $translationKey): ResponseCollectionInterface
    {
        return $this->prepareResponse($type, $translationKey, 'error', 400);
    }

    /**
     * @param string $translationKey
     *
     * @return ResponseCollectionInterface
     */
    final public function invalid(string $translationKey): ResponseCollectionInterface
    {
        return $this->prepareResponse(ApiResponseTypeEnum::INVALID, $translationKey, 'error', 400);
    }

    /**
     * @param string $translationKey
     *
     * @return ResponseCollectionInterface
     */
    final public function notActive(string $translationKey): ResponseCollectionInterface
    {
        return $this->prepareResponse(ApiResponseTypeEnum::CHECK_ACTIVE, $translationKey, 'error', 403);
    }

    /**
     * @param string $translationKey
     *
     * @return ResponseCollectionInterface
     */
    final public function successRecoveryRequest(string $translationKey): ResponseCollectionInterface
    {
        return $this->prepareResponse(ApiResponseTypeEnum::RECOVERY_REQUEST, $translationKey, 'success', 200);
    }

    /**
     * @param string $translationKey
     *
     * @return ResponseCollectionInterface
     */
    final public function successRecovery(string $translationKey): ResponseCollectionInterface
    {
        return $this->prepareResponse(ApiResponseTypeEnum::RECOVERY, $translationKey, 'success', 200);
    }

    /**
     * @param string $translationKey
     *
     * @return ResponseCollectionInterface
     */
    final public function successSubscribe(string $translationKey): ResponseCollectionInterface
    {
        return $this->prepareResponse(ApiResponseTypeEnum::SUBSCRIBE, $translationKey, 'success', 200);
    }

    final public function alreadySubscribed(): ResponseCollectionInterface
    {
        return $this->prepareResponse(
            ApiResponseTypeEnum::SUBSCRIBE,
            'artist@alreadySubscribed',
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
     * @inheritDoc
     */
    public function sendResponse(?string $status = null, ?int $code = null, array $headers = []): JsonResponse
    {
        return $this->getResponse($status, $code)->make($headers);
    }

    /**
     * @param ApiResponseTypeEnum $type
     * @param string              $translationKey
     * @param string              $status
     * @param int                 $code
     *
     * @return ResponseCollectionInterface
     */
    private function prepareResponse(ApiResponseTypeEnum $type, string $translationKey, string $status, int $code): ResponseCollectionInterface
    {
        $this->apiResponseSchema->setMessage($type, $this->translator->getTranslation($translationKey));

        $this->status = $status;
        $this->code = $code;

        return $this;
    }
}