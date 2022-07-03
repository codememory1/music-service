<?php

namespace App\EventListener;

use App\Rest\Http\Exceptions\ApiResponseException;
use App\Rest\Http\Response;
use App\Rest\Http\ResponseSchema;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * Class ApiExceptionListener.
 *
 * @package App\EventListener
 *
 * @author  Codememory
 */
class ApiExceptionListener
{
    private ResponseSchema $responseSchema;
    private Response $response;

    public function __construct(ResponseSchema $responseSchema, Response $response)
    {
        $this->responseSchema = $responseSchema;
        $this->response = $response;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if ($throwable instanceof ApiResponseException) {
            $this->responseSchema->setType($throwable->type);
            $this->responseSchema->setMessage($throwable->translationKey, $throwable->parameters);
            $this->responseSchema->setStatusCode($throwable->statusCode);
            $this->responseSchema->setData($throwable->data);

            $this->response->getResponse($this->responseSchema)->send();
        }
    }
}