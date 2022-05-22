<?php

namespace App\Rest\Http;

use App\Enum\ResponseTypeEnum;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ResponseCollection.
 *
 * @package App\Rest\Http
 *
 * @author  Codememory
 */
class ResponseCollection
{
    /**
     * @var ResponseSchema
     */
    private ResponseSchema $responseSchema;

    /**
     * @var Response
     */
    private Response $response;

    /**
     * @param ResponseSchema $responseSchema
     * @param Response       $response
     */
    public function __construct(ResponseSchema $responseSchema, Response $response)
    {
        $this->responseSchema = $responseSchema;
        $this->response = $response;
    }

    /**
     * @param string $translationKey
     * @param array  $data
     * @param array  $headers
     *
     * @return JsonResponse
     */
    public function successCreate(string $translationKey, array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::CREATE, $translationKey, $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    /**
     * @param string $translationKey
     * @param array  $data
     * @param array  $headers
     *
     * @return JsonResponse
     */
    public function successUpdate(string $translationKey, array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::UPDATE, $translationKey, $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    /**
     * @param string $translationKey
     * @param array  $data
     * @param array  $headers
     *
     * @return JsonResponse
     */
    public function successDelete(string $translationKey, array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::DELETE, $translationKey, $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function successAuthorization(array $data, array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::SUCCESS_AUTHORIZATION, 'auth@successAuthorization', $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function successRegistration(array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::SUCCESS_REGISTRATION, 'registration@successRegistration', $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    /**
     * @param int              $statusCode
     * @param ResponseTypeEnum $type
     * @param array|string     $translationKey
     * @param array            $data
     *
     * @return void
     */
    private function initResponseSchema(int $statusCode, ResponseTypeEnum $type, array|string $translationKey, array $data = []): void
    {
        $this->responseSchema->setStatusCode($statusCode);
        $this->responseSchema->setType($type);
        $this->responseSchema->setMessage($translationKey);
        $this->responseSchema->setData($data);
    }
}