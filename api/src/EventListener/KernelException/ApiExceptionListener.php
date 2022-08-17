<?php

namespace App\EventListener\KernelException;

use App\Exception\Interfaces\HttpExceptionInterface;
use App\Rest\Http\Request;
use App\Rest\Response\HttpResponse;
use App\Rest\Response\HttpSchema;
use App\Service\TranslationService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener('kernel.exception')]
final class ApiExceptionListener
{
    private HttpResponse $httpResponse;
    private HttpSchema $httpSchema;
    private Request $request;
    private TranslationService $translationService;

    public function __construct(HttpResponse $httpResponse, HttpSchema $httpSchema, Request $request, TranslationService $translationService)
    {
        $this->httpResponse = $httpResponse;
        $this->httpSchema = $httpSchema;
        $this->request = $request;
        $this->translationService = $translationService;
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
        $this->httpSchema->setStatusCode($exception->getStatusCode());
        $this->httpSchema->setType($exception->getResponseType());
        $this->httpSchema->setData($exception->getData());
        $this->httpSchema->setParameters($exception->getParameters());
        $this->httpSchema->setMessage($this->getTranslationMessage(
            $this->request->getRequest()->getLocale(),
            $exception->getMessageTranslationKey()
        ));

        $this->httpResponse->getResponse($this->httpSchema)->send();
    }

    private function getTranslationMessage(string $locale, string $translationKey): ?string
    {
        $this->translationService->setLocale($locale);

        return $this->translationService->getTranslation($translationKey);
    }
}