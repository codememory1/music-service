<?php

namespace App\Rest\Http;

use App\Rest\Http\Interfaces\ResponseSchemaInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Response.
 *
 * @package App\Rest\Http
 *
 * @author  Codememory
 */
class Response
{
    /**
     * @param ResponseSchemaInterface $responseSchema
     * @param array                   $headers
     *
     * @return JsonResponse
     */
    public function getResponse(ResponseSchemaInterface $responseSchema, array $headers = []): JsonResponse
    {
        return new JsonResponse($responseSchema->getSchema(), $responseSchema->getStatusCode(), $headers);
    }
}