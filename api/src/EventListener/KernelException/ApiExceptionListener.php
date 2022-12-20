<?php

namespace App\EventListener\KernelException;

use App\Exception\Interfaces\HttpExceptionInterface;
use App\Rest\Response\HttpResponse;
use App\Rest\Response\Scheme\HttpErrorScheme;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener('kernel.exception')]
final class ApiExceptionListener
{
    public function __construct(
        private readonly HttpResponse $httpResponse
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if ($throwable instanceof HttpExceptionInterface) {
            $this->httpException($throwable);
        }
    }

    private function httpException(HttpExceptionInterface $exception): void
    {
        $httpScheme = new HttpErrorScheme(
            $exception->getHttpCode(),
            $exception->getPlatformCode(),
            $exception->getMessage(),
            $exception->getParameters()
        );

        $this->httpResponse->getResponse($httpScheme, $exception->getHeaders())->send();
    }
}