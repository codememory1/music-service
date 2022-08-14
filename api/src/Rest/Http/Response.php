<?php

namespace App\Rest\Http;

use App\Rest\Http\Interfaces\ResponseSchemaInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class Response
{
    public function getResponse(ResponseSchemaInterface $responseSchema, array $headers = []): JsonResponse
    {
        return new JsonResponse($responseSchema->getSchema(), $responseSchema->getStatusCode(), $headers);
    }
}