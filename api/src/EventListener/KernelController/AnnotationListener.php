<?php

namespace App\EventListener\KernelController;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use function is_array;
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
    /**
     * @var ReverseContainer
     */
    private ReverseContainer $container;

    /**
     * @param ReverseContainer $container
     */
    public function __construct(ReverseContainer $container)
    {
        $this->container = $container;
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
            [$controller, $method] = $event->getController();

            $reflectionClass = new ReflectionClass($controller);

            $this->handleMethod($reflectionClass, $method);
        }
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param string          $methodName
     *
     * @throws ReflectionException
     *
     * @return void
     */
    private function handleMethod(ReflectionClass $reflectionClass, string $methodName): void
    {
        $reflectionMethod = $reflectionClass->getMethod($methodName);
        $attributes = $reflectionMethod->getAttributes();

        foreach ($attributes as $attribute) {
            $annotation = $attribute->newInstance();

            if ($annotation instanceof MethodAnnotationInterface) {
                /** @var MethodAnnotationHandlerInterface $annotationHandler */
                $annotationHandler = $this->container->getService($annotation->getHandler());

                $annotationHandler->handle($annotation);
            }
        }
    }
}