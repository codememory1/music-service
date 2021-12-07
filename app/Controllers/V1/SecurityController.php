<?php

namespace App\Controllers\V1;

use App\Services\Auth\AuthorizationService;
use App\Services\Auth\RefreshAccessTokenService;
use App\Services\Registration\AccountActivationService;
use App\Services\Registration\RegisterService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\ResponseInterface;
use Codememory\HttpFoundation\Request\Request;
use JetBrains\PhpStorm\NoReturn;
use ReflectionException;

/**
 * Class SecurityController
 *
 * @package App\Controllers\V1
 *
 * @author  Danil
 */
class SecurityController extends AbstractApiController
{

    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

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

    }

    /**
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function auth(): void
    {

        /** @var AuthorizationService $authorizationService */
        $authorizationService = $this->getService('Auth\Authorization');

        // Try to authorize the user and give an authorization response
        $authorizationResponse = $authorizationService->authorize($this->validatorManager());

        $this->response->json($authorizationResponse->getResponse(), $authorizationResponse->getStatus());

    }

    /**
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function register(): void
    {

        /** @var RegisterService $registerService */
        $registerService = $this->getService('Registration\Register');

        // Receiving a response about user registration
        $registrationResponse = $registerService->register($this->validatorManager());

        $this->response->json($registrationResponse->getResponse(), $registrationResponse->getStatus());

    }

    /**
     * @param string $token
     *
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function accountActivation(string $token): void
    {

        /** @var AccountActivationService $registerService */
        $registerService = $this->getService('Registration\AccountActivation');

        // Receiving an account activation response
        $activationResponse = $registerService->activate($token);

        $this->response->json($activationResponse->getResponse(), $activationResponse->getStatus());

    }

    /**
     * @param Request $request
     *
     * @return void
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function refreshAccessToken(Request $request): void
    {

        $refreshToken = (string) $request->cookie->get('refresh_token');

        /** @var RefreshAccessTokenService $refreshAccessTokenService */
        $refreshAccessTokenService = $this->getService('Auth\RefreshAccessToken');

        // Answer about updating AccessToken
        $refreshResponse = $refreshAccessTokenService->refresh($refreshToken);

        $this->response->json($refreshResponse->getResponse(), $refreshResponse->getStatus());

    }

}