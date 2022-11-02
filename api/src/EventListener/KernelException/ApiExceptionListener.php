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
    public function __construct(
        private readonly HttpResponse $httpResponse,
        private readonly HttpSchema $httpSchema,
        private readonly Request $request,
        private readonly TranslationService $translation
    ) {}

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
        $this->translation->setLocale($locale);

        return $this->translation->getTranslation($translationKey);
    }
}