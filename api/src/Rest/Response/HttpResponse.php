<?php

namespace App\Rest\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class HttpResponse
{
    public function getResponse(HttpSchema $httpResponseSchema, array $headers = []): JsonResponse
    {
        return new JsonResponse($httpResponseSchema->getSchema(), $httpResponseSchema->getStatusCode(), $headers);
    }
}