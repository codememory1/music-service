<?php

namespace App\Rest\Response;

use App\Rest\Response\Interfaces\HttpSchemeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class HttpResponse
{
    public function getResponse(HttpSchemeInterface $scheme, array $headers = []): JsonResponse
    {
        return new JsonResponse($scheme->use(), $scheme->getHttpCode(), $headers);
    }
}