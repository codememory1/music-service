<?php

namespace App\Rest\Response;

use App\Enum\ResponseTypeEnum;
use App\Rest\Http\Request;
use App\Service\TranslationService;
use Symfony\Component\HttpFoundation\JsonResponse;

class HttpResponseCollection
{
    private HttpSchema $httpResponseSchema;
    private HttpResponse $httpResponse;
    private Request $request;
    private TranslationService $translationService;

    public function __construct(HttpSchema $httpResponseSchema, HttpResponse $httpResponse, Request $request, TranslationService $translationService)
    {
        $this->httpResponseSchema = $httpResponseSchema;
        $this->httpResponse = $httpResponse;
        $this->request = $request;
        $this->translationService = $translationService;
    }

    final public function successCreate(string $translationKey, array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::CREATE, $translationKey, data: $data);

        return $this->httpResponse->getResponse($this->httpResponseSchema, $headers);
    }

    final public function successUpdate(string $translationKey, array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::UPDATE, $translationKey, data: $data);

        return $this->httpResponse->getResponse($this->httpResponseSchema, $headers);
    }

    final public function successDelete(string $translationKey, array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::DELETE, $translationKey, data: $data);

        return $this->httpResponse->getResponse($this->httpResponseSchema, $headers);
    }

    final public function successAuthorization(array $data, array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::SUCCESS_AUTHORIZATION, 'auth@successAuthorization', data: $data);

        return $this->httpResponse->getResponse($this->httpResponseSchema, $headers);
    }

    final public function successRegistration(array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::SUCCESS_REGISTRATION, 'registration@successRegistration', data: $data);

        return $this->httpResponse->getResponse($this->httpResponseSchema, $headers);
    }

    final public function dataOutput(array $data, array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::DATA_OUTPUT, 'common@dataOutput', data: $data);

        return $this->httpResponse->getResponse($this->httpResponseSchema, $headers);
    }

    final public function successLogout(array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::DELETE, 'logout@successLogout', data: $data);

        return $this->httpResponse->getResponse($this->httpResponseSchema, $headers);
    }

    final public function successSendRequestRestorationPassword(array $data = [], array $headers = []): JsonResponse
    {
        $this->initResponseSchema(200, ResponseTypeEnum::SUCCESS_SEND, 'passwordReset@successSendRequestRestoration', data: $data);

        return $this->httpResponse->getResponse($this->httpResponseSchema, $headers);
    }

    private function initResponseSchema(int $statusCode, ResponseTypeEnum $responseTypeEnum, array|string $translationKey, array $parameters = [], array $data = []): void
    {
        $this->translationService->setLocale($this->request->getRequest()->getLocale());

        $this->httpResponseSchema->setStatusCode($statusCode);
        $this->httpResponseSchema->setType($responseTypeEnum);
        $this->httpResponseSchema->setMessage($this->translationService->getTranslation($translationKey));
        $this->httpResponseSchema->setData($data);
        $this->httpResponseSchema->setParameters($parameters);
    }
}