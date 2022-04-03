<?php

namespace App\AnnotationListener;

use App\Interfaces\AnnotationListenerInterface;
use App\Rest\Http\ApiResponseSchema;
use App\Rest\Http\Request;
use App\Rest\Http\Response;
use App\Rest\Translator;
use App\Security\TokenAuthenticator;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
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
     * @var ManagerRegistry
     */
    protected ManagerRegistry $managerRegistry;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $em;

    /**
     * @var Translator
     */
    protected Translator $translator;

    /**
     * @var ApiResponseSchema
     */
    protected ApiResponseSchema $apiResponseSchema;

    /**
     * @var TokenAuthenticator
     */
    protected TokenAuthenticator $authenticator;

    /**
     * @param Request           $request
     * @param ManagerRegistry   $managerRegistry
     * @param Translator        $translator
     * @param ApiResponseSchema $apiResponseSchema
     */
    public function __construct(
        Request $request,
        ManagerRegistry $managerRegistry,
        Translator $translator,
        ApiResponseSchema $apiResponseSchema
    ) {
        $this->managerRegistry = $managerRegistry;
        $this->em = $managerRegistry->getManager();
        $this->translator = $translator;
        $this->apiResponseSchema = $apiResponseSchema;
        $this->authenticator = new TokenAuthenticator($request, $managerRegistry);
    }

    /**
     * @param string $status
     * @param int    $code
     *
     * @return void
     */
    #[NoReturn]
    protected function response(string $status, int $code): void
    {
        $response = new Response($this->apiResponseSchema, $status, $code);

        exit($response->make());
    }

    /**
     * @param string $key
     * @param string $default
     *
     * @return string
     */
    protected function getTranslation(string $key, string $default = ''): string
    {
        return $this->translator->getTranslation($key, $default);
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