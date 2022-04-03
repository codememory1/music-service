<?php

namespace App\EventListener;

use App\Enum\AnnotationListenerEnum;
use App\Interfaces\AnnotationListenerInterface;
use App\Rest\ClassHelper\AttributeData;
use App\Rest\Http\ApiResponseSchema;
use App\Rest\Http\Request;
use App\Rest\Translator;
use Doctrine\Persistence\ManagerRegistry;
use function is_array;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * Class AnnotationListener.
 *
 * @package App\EventListener
 *
 * @author  Codememory
 */
class AnnotationListener
{
    /**
     * @param Request           $request
     * @param ManagerRegistry   $managerRegistry
     * @param Translator        $translator
     * @param ApiResponseSchema $apiResponseSchema
     */
    public function __construct(
        private Request $request,
        private ManagerRegistry $managerRegistry,
        private Translator $translator,
        private ApiResponseSchema $apiResponseSchema
    ) {
    }

    /**
     * @param ControllerEvent $event
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function onKernelController(ControllerEvent $event): void
    {
        if (is_array($event->getController())) {
            $this->handler($event);
        }
    }

    /**
     * @param ControllerEvent $event
     *
     * @throws ReflectionException
     *
     * @return void
     */
    private function handler(ControllerEvent $event): void
    {
        [$controller, $method] = $event->getController();

        $reflectionClass = new ReflectionClass($controller);
        $reflectionMethod = $reflectionClass->getMethod($method);

        foreach ($reflectionMethod->getAttributes() as $attribute) {
            $this->attributeHandler($attribute);
        }
    }

    /**
     * @param ReflectionAttribute $reflectionAttribute
     *
     * @return void
     */
    private function attributeHandler(ReflectionAttribute $reflectionAttribute): void
    {
        if (array_key_exists($reflectionAttribute->getName(), AnnotationListenerEnum::LISTENERS)) {
            $listenerNamespace = AnnotationListenerEnum::LISTENERS[$reflectionAttribute->getName()];
            /** @var AnnotationListenerInterface $listener */
            $listener = new $listenerNamespace(
                $this->request,
                $this->managerRegistry,
                $this->translator,
                $this->apiResponseSchema
            );

            $listener->listen(new AttributeData($reflectionAttribute));
        }
    }
}