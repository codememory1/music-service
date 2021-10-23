<?php

namespace App\Controllers\V1;

use App\Services\Auth\AuthorizationService;
use App\Services\PasswordReset\RestoreRequestService;
use App\Services\Registration\AccountActivationService;
use App\Services\Registration\RegisterService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Event\Exceptions\EventExistException;
use Codememory\Components\Event\Exceptions\EventNotExistException;
use Codememory\Components\Event\Exceptions\EventNotImplementInterfaceException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\ResponseInterface;
use JetBrains\PhpStorm\NoReturn;
use Kernel\Controller\AbstractController;
use ReflectionException;

/**
 * Class SecurityController
 *
 * @package App\Controllers\V1
 *
 * @author  Danil
 */
class SecurityController extends AbstractController
{

    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @throws BuilderNotCurrentSectionException
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var ResponseInterface $response */
        $response = $this->get('response');
        $this->response = $response;

        $this->em = $this->getDatabase()->getEntityManager();

    }

    /**
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws InvalidTimezoneException
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    #[NoReturn]
    public function auth(): void
    {

        /** @var AuthorizationService $authorizationService */
        $authorizationService = $this->getService('Auth\Authorization');

        // Try to authorize the user and give an authorization response
        $authorizationResponse = $authorizationService->authorize($this->validatorManager(), $this->em);

        $this->response->json($authorizationResponse->getResponse(), $authorizationResponse->getStatus());

    }

    /**
     * @throws BuilderNotCurrentSectionException
     * @throws EventExistException
     * @throws EventNotExistException
     * @throws EventNotImplementInterfaceException
     * @throws InvalidTimezoneException
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function register(): void
    {

        /** @var RegisterService $registerService */
        $registerService = $this->getService('Registration\Register');

        // Receiving a response about user registration
        $registrationResponse = $registerService->register($this->validatorManager(), $this->em);

        $this->response->json($registrationResponse->getResponse(), $registrationResponse->getStatus());

    }

    /**
     * @param string $token
     *
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function accountActivation(string $token): void
    {

        /** @var AccountActivationService $registerService */
        $registerService = $this->getService('Registration\AccountActivation');

        // Receiving an account activation response
        $activationResponse = $registerService->activate($this->em, $token);

        $this->response->json($activationResponse->getResponse(), $activationResponse->getStatus());

    }

    /**
     * Send password recovery request
     *
     * @return void
     * @throws BuilderNotCurrentSectionException
     * @throws EventExistException
     * @throws EventNotExistException
     * @throws EventNotImplementInterfaceException
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function restoreRequest(): void
    {

        /** @var RestoreRequestService $restoreRequestService */
        $restoreRequestService = $this->getService('PasswordReset\RestoreRequest');

        // We send a message to the mail with a password recovery code
        $sendResponse = $restoreRequestService->send($this->validatorManager(), $this->em);

        $this->response->json($sendResponse->getResponse(), $sendResponse->getStatus());

    }

}