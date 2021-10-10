<?php

namespace App\Controllers\V1;

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
 * Class RegisterController
 *
 * @package App\Controllers\Api\v1
 *
 * @author  Danil
 */
class RegisterController extends AbstractController
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
    public function activation(string $token): void
    {

        /** @var AccountActivationService $registerService */
        $registerService = $this->getService('Registration\AccountActivation');

        // Receiving an account activation response
        $activationResponse = $registerService->activate($this->em, $token);

        $this->response->json($activationResponse->getResponse(), $activationResponse->getStatus());

    }

}