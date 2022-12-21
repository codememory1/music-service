<?php

namespace App\Rest\Response\Http;

use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\Rest\Response\Interfaces\ResponseCollectorInterface;
use App\Rest\Response\Interfaces\ResponseCreatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class HttpResponseCreator implements ResponseCreatorInterface
{
    /**
     * @param HttpResponseCollectorInterface $collector
     */
    public function response(ResponseCollectorInterface $collector): JsonResponse
    {
        return new JsonResponse($collector->collect()->getCollectedResponse(), $collector->getHttpCode(), $collector->getHeaders());
    }
}