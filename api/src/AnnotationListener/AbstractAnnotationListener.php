<?php

namespace App\AnnotationListener;

use App\Interfaces\AnnotationListenerInterface;
use App\Rest\Http\Request;
use App\Rest\Http\ResponseCollection;
use App\Security\Auth\Authenticator;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use JetBrains\PhpStorm\Pure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * Class AbstractAnnotationListener.
 *
 * @package App\AnnotationListener
 *
 * @author  Codememory
 */
abstract class AbstractAnnotationListener implements AnnotationListenerInterface
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * @var ResponseCollection
     */
    protected ResponseCollection $responseCollection;

    /**
     * @var Authenticator
     */
    protected Authenticator $authenticator;

    /**
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param ResponseCollection     $responseCollection
     * @param Authenticator          $authenticator
     */
    public function __construct(
        Request $request,
        EntityManagerInterface $em,
        ResponseCollection $responseCollection,
        Authenticator $authenticator
    ) {
        $this->request = $request;
        $this->em = $em;
        $this->responseCollection = $responseCollection;
        $this->authenticator = $authenticator;
    }

    /**
     * @return void
     */
    #[NoReturn]
    protected function response(): void
    {
        exit($this->responseCollection->getResponse()->make());
    }

    /**
     * @param ControllerEvent $event
     *
     * @return AbstractController
     */
    #[Pure]
    protected function getController(ControllerEvent $event): AbstractController
    {
        return $event->getController()[0];
    }

    /**
     * @param ControllerEvent $event
     *
     * @return string
     */
    #[Pure]
    protected function getMethodName(ControllerEvent $event): string
    {
        return $event->getController()[1];
    }
}