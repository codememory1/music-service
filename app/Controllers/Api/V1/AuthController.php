<?php

namespace App\Controllers\Api\V1;

use App\Services\Auth\AuthorizationService;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\HttpFoundation\Interfaces\ResponseInterface;
use JetBrains\PhpStorm\NoReturn;
use Kernel\Controller\AbstractController;
use ReflectionException;

/**
 * Class AuthController
 *
 * @package App\Controllers\Api\V1
 *
 * @author  Danil
 */
class AuthController extends AbstractController
{

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

        /** @var ResponseInterface $response */
        $response = $this->get('response');
        $authorizationResponse = $authorizationService->authorize(
            $this->validatorManager(),
            $this->getDatabase()->getEntityManager()
        );

        $response->json($authorizationResponse->getResponse(), $authorizationResponse->getStatus());

    }

}