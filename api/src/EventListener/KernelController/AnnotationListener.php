<?php

namespace App\EventListener\KernelController;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use function is_array;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\DependencyInjection\ReverseContainer;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * Class AnnotationListener.
 *
 * @package App\EventListener\KernelController
 *
 * @author  Codememory
 */
class AnnotationListener
{
    private ReverseContainer $container;

    public function __construct(ReverseContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @throws ReflectionException
     */
    public function onKernelController(ControllerEvent $event): void
    {
        if (is_array($event->getController())) {
            [$controller, $method] = $event->getController();

            $reflectionClass = new ReflectionClass($controller);

            $this->handleClass($reflectionClass);
            $this->handleMethod($reflectionClass, $method);
        }
    }

    private function handleClass(ReflectionClass $reflectionClass): void
    {
        foreach ($reflectionClass->getAttributes() as $attribute) {
            $this->annotationHandler($attribute);
        }
    }

    /**
     * @throws ReflectionException
     */
    private function handleMethod(ReflectionClass $reflectionClass, string $methodName): void
    {
        $reflectionMethod = $reflectionClass->getMethod($methodName);
        $attributes = $reflectionMethod->getAttributes();

        foreach ($attributes as $attribute) {
            $this->annotationHandler($attribute);
        }
    }

    private function annotationHandler(ReflectionAttribute $attribute): void
    {
        $annotation = $attribute->newInstance();

        if ($annotation instanceof MethodAnnotationInterface) {
            /** @var MethodAnnotationHandlerInterface $annotationHandler */
            $annotationHandler = $this->container->getService($annotation->getHandler());

            $annotationHandler->handle($annotation);
        }
    }
}