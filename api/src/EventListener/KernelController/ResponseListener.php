<?php

namespace App\EventListener\KernelController;

use App\Rest\Response\Http\HttpResponseCreator;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ViewEvent;

#[AsEventListener('kernel.view')]
final class ResponseListener
{
    public function __construct(
        private readonly HttpResponseCreator $httpResponseCreator
    ) {
    }

    public function onKernelView(ViewEvent $event): void
    {
        $endpointResult = $event->getControllerResult();

        if ($event->getControllerResult() instanceof HttpResponseCollectorInterface) {
            $event->setResponse($this->httpResponseCreator->response($endpointResult));
        }
    }
}