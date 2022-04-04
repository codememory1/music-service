<?php

namespace App\EventListener;

use App\Enum\AnnotationListenerEnum;
use App\Interfaces\AnnotationListenerInterface;
use App\Rest\ClassHelper\AttributeData;
use App\Rest\Http\Request;
use App\Rest\Http\ResponseCollection;
use App\Security\TokenAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
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
     * @var Request
     */
    private Request $request;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var ResponseCollection
     */
    private ResponseCollection $responseCollection;

    /**
     * @var TokenAuthenticator
     */
    private TokenAuthenticator $authenticator;

    /**
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param ResponseCollection     $responseCollection
     * @param TokenAuthenticator     $tokenAuthenticator
     */
    public function __construct(
        Request $request,
        EntityManagerInterface $em,
        ResponseCollection $responseCollection,
        TokenAuthenticator $tokenAuthenticator
    ) {
        $this->request = $request;
        $this->em = $em;
        $this->responseCollection = $responseCollection;
        $this->authenticator = $tokenAuthenticator;
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
                $this->em,
                $this->responseCollection,
                $this->authenticator
            );

            $listener->listen(new AttributeData($reflectionAttribute));
        }
    }
}