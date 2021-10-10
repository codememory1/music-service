<?php

namespace App\Controllers\Api\V1;

use App\Orm\Entities\UserEntity;
use App\Services\Auth\AuthorizationService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\ResponseInterface;
use Kernel\Controller\AbstractController;
use ReflectionException;

/**
 * Class AbstractAuthorizationController
 *
 * @package App\Controllers\Api\V1
 *
 * @author  Danil
 */
abstract class AbstractAuthorizationController extends AbstractController
{

    /**
     * @var AuthorizationService
     */
    private AuthorizationService $authorizationService;

    /**
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * @var ResponseApiCollectorService
     */
    protected ResponseApiCollectorService $apiResponse;

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @throws BuilderNotCurrentSectionException
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var AuthorizationService $authorizationService */
        $authorizationService = $this->getService('Auth\Authorization');
        $this->authorizationService = $authorizationService;

        /** @var ResponseInterface $response */
        $response = $this->get('response');
        $this->response = $response;

        $this->em = $this->getDatabase()->getEntityManager();

        /** @var ResponseApiCollectorService $apiResponse */
        $apiResponse = $this->get('api-response');
        $this->apiResponse = $apiResponse;

    }

    /**
     * @return UserEntity|bool
     * @throws ReflectionException
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     */
    protected function isAuthWithData(): UserEntity|bool
    {

        return $this->authorizationService->isAuth($this->getDatabase()->getEntityManager());

    }

    /**
     * @return UserEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    protected function isAuthWithResponse(): UserEntity
    {

        if (false === $authUser = $this->isAuthWithData()) {
            $this->response->json($this->apiResponse->create(401, ['Unauthorized'])->getResponse(), 401);
        }

        return $authUser;

    }

    /**
     * @return bool
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    protected function isAuth(): bool
    {

        return false !== $this->isAuthWithData();

    }

    /**
     * @param UserEntity $userEntity
     * @param string[]   $roles
     *
     * @return bool
     */
    protected function isNotRoles(UserEntity $userEntity, array $roles): bool
    {

        if (in_array($userEntity->getRole(), $roles)) {
            $this->response->json($this->responseIncorrectRole()->getResponse(), 403);
        }

        return true;

    }

    /**
     * @param UserEntity $userEntity
     * @param string[]   $roles
     *
     * @return bool
     */
    protected function isRoles(UserEntity $userEntity, array $roles): bool
    {

        if (!in_array($userEntity->getRole(), $roles)) {
            $this->response->json($this->responseIncorrectRole()->getResponse(), 403);
        }

        return true;

    }

    /**
     * @return ResponseApiCollectorService
     */
    private function responseIncorrectRole(): ResponseApiCollectorService
    {

        return $this->apiResponse->create(403, ['Incorrect role']);

    }

}