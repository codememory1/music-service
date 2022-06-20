<?php

namespace App\EventListener;

use App\Repository\TranslationRepository;
use App\Rest\Http\Exceptions\ApiResponseException;
use App\Rest\Http\Response;
use App\Rest\Http\ResponseSchema;
use Symfony\Component\HttpFoundation\RequestStack;
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
    /**
     * @var ResponseSchema
     */
    private ResponseSchema $responseSchema;

    /**
     * @var Response
     */
    private Response $response;

    /**
     * @param RequestStack          $requestStack
     * @param TranslationRepository $translationRepository
     */
    public function __construct(ResponseSchema $responseSchema, Response $response)
    {
        $this->responseSchema = $responseSchema;
        $this->response = $response;
    }

    /**
     * @param ExceptionEvent $event
     *
     * @return void
     */
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