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
    private ResponseSchema $responseSchema;
    private Response $response;

    public function __construct(ResponseSchema $responseSchema, Response $response)
    {
        $this->responseSchema = $responseSchema;
        $this->response = $response;
    }

    public function successCreate(string $translationKey, array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::CREATE, $translationKey, data: $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    public function successUpdate(string $translationKey, array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::UPDATE, $translationKey, data: $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    public function successDelete(string $translationKey, array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::DELETE, $translationKey, data: $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    public function successAuthorization(array $data, array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::SUCCESS_AUTHORIZATION, 'auth@successAuthorization', data: $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    public function successRegistration(array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::SUCCESS_REGISTRATION, 'registration@successRegistration', data: $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    public function dataOutput(array $data, array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::DATA_OUTPUT, 'common@dataOutput', data: $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    public function successLogout(array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::DELETE, 'logout@successLogout', data: $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    public function successSendRequestRestorationPassword(array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::SUCCESS_SEND, 'passwordReset@successSendRequestRestoration', data: $data);

        return $this->response->getResponse($this->responseSchema, $headers);
    }

    private function initResponseSchema(int $statusCode, ResponseTypeEnum $type, array|string $translationKey, array $parameters = [], array $data = []): void
    {
        $this->responseSchema->setStatusCode($statusCode);
        $this->responseSchema->setType($type);
        $this->responseSchema->setMessage($translationKey, $parameters);
        $this->responseSchema->setData($data);
    }
}